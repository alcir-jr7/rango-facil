<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Lista todos os pedidos do usuário logado.
     */
    public function index()
    {
        $orders = Order::with(['products', 'store', 'review'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['paid', 'delivered'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'id'          => $order->id,
                    'status'      => $order->status,
                    'total_price' => $order->total_price,
                    'created_at'  => $order->created_at->format('d/m/Y H:i'),
                    'store'       => $order->store ? [
                        'id'   => $order->store->id,
                        'name' => $order->store->name,
                    ] : null,
                    'products'    => $order->products->map(fn($p) => [
                        'id'       => $p->id,
                        'name'     => $p->name,
                        'quantity' => $p->pivot->quantity,
                        'price'    => $p->pivot->price,
                    ]),
                    'review'      => $order->review ? [
                        'id'      => $order->review->id,
                        'rating'  => $order->review->rating,
                        'comment' => $order->review->comment,
                    ] : null,
                ];
            });

        return inertia('Orders/Index', ['orders' => $orders]);
    }

    /**
     * Marcar pedido como entregue/recebido.
     */
    public function markDelivered(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'paid', 422, 'Pedido não pode ser marcado como entregue.');

        $order->update(['status' => 'delivered']);

        return redirect()
            ->route('orders.rate', $order->id)
            ->with('success', 'Pedido confirmado como recebido!');
    }

    /**
     * Exibe formulário de avaliação.
     */
    public function rateForm(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'delivered', 422, 'Só é possível avaliar pedidos entregues.');
        abort_if($order->review !== null, 422, 'Pedido já foi avaliado.');

        $order->load(['products', 'store']);

        return inertia('Orders/Rate', [
            'order' => [
                'id'          => $order->id,
                'total_price' => $order->total_price,
                'created_at'  => $order->created_at->format('d/m/Y H:i'),
                'store'       => $order->store ? [
                    'id'   => $order->store->id,
                    'name' => $order->store->name,
                ] : null,
                'products'    => $order->products->map(fn($p) => [
                    'id'       => $p->id,
                    'name'     => $p->name,
                    'quantity' => $p->pivot->quantity,
                ]),
            ],
        ]);
    }

    // ─────────────────────────────────────────────
    // Fluxo de criação de pedido (existente)
    // ─────────────────────────────────────────────

    public function create()
    {
        $user  = auth()->user();
        $total = $this->getCartTotal($user);

        return inertia('Orders/Create', [
            'user' => [
                'name'         => $user->name,
                'email'        => $user->email,
                'phone_number' => $user->phone_number ?? '',
            ],
            'total' => $total,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cpf'            => ['required', 'string', 'min:11'],
            'payment_method' => ['required', 'in:pix,card'],
        ]);

        $total = $this->getCartTotal(auth()->user());

        session([
            'checkout' => [
                'cpf'            => $request->cpf,
                'payment_method' => $request->payment_method,
                'total'          => $total,
            ],
        ]);

        return redirect()->route('orders.review');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Carrinho vazio');
        }

        // Descobre a loja dos itens do carrinho
        $storeId = $cart->items->first()?->product?->store_id;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id'  => $user->id,
                'store_id' => $storeId,
                'status'   => 'paid',
            ]);

            $total = 0;

            foreach ($cart->items as $item) {
                $price = $item->product->price
                    ?? $item->product->price_cents / 100;

                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price'    => $price,
                ]);

                $total += $price * $item->quantity;
            }

            $order->update(['total_price' => $total]);

            $cart->items()->delete();

            DB::commit();

            return redirect()
                ->route('orders.index')
                ->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao finalizar pedido: ' . $e->getMessage());
        }
    }

    public function review()
    {
        $checkout = session('checkout');

        if (!$checkout) {
            return redirect()->route('orders.create');
        }

        return inertia('Orders/Review', [
            'payment_method' => $checkout['payment_method'],
            'cpf'            => $checkout['cpf'],
            'total'          => $checkout['total'],
        ]);
    }

    public function pay(Request $request)
    {
        $checkout = session('checkout');

        if (!$checkout) {
            return redirect()->route('orders.create');
        }

        if ($checkout['payment_method'] === 'card') {
            $request->validate([
                'card_number' => 'required|min:16',
                'card_name'   => 'required|string',
                'card_cvc'    => 'required|min:3',
                'card_expiry' => 'required',
            ]);
        }

        return $this->store($request);
    }

    private function getCartTotal($user)
    {
        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return 0;
        }

        $total = 0;

        foreach ($cart->items as $item) {
            $price  = $item->product->price
                ?? $item->product->price_cents / 100;
            $total += $price * $item->quantity;
        }

        return $total;
    }
}
