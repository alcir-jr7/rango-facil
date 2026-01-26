<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // TELA 1
    public function create()
    {
        $user = auth()->user();

        return inertia('Orders/Create', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number ?? '',
            ],
        ]);
    }

    // RECEBE DADOS DO FORM
    public function checkout(Request $request)
    {
        $request->validate([
            'cpf' => ['required', 'string', 'min:11'],
            'payment_method' => ['required', 'in:pix,card'],
        ]);

        // Por enquanto só guardamos em sessão
        session([
            'checkout' => [
                'cpf' => $request->cpf,
                'payment_method' => $request->payment_method,
            ],
        ]);

        // Próxima tela (que criaremos depois)
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

        DB::beginTransaction();

        try {
            // 1. Criar pedido
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'paid', // depois pode virar pending
            ]);

            $total = 0;

            // 2. Copiar itens do carrinho
            foreach ($cart->items as $item) {
                $price = $item->product->price
                    ?? $item->product->price_cents / 100;

                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                $total += $price * $item->quantity;
            }

            // 3. Atualizar total
            $order->update([
                'total_price' => $total,
            ]);

            // 4. Limpar carrinho
            $cart->items()->delete();

            DB::commit();

            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao finalizar pedido');
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
    'cpf' => $checkout['cpf'],
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
    'card_name' => 'required|string',
    'card_cvc' => 'required|min:3',
    'card_expiry' => 'required',
    ]);
    }
    return app(OrderController::class)->store($request);
    }
}