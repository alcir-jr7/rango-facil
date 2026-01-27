<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $total = $this->getCartTotal($user);
        return inertia('Orders/Create', [
            'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number ?? '',
            ],
            'total' => $total,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cpf' => ['required', 'string', 'min:11'],
            'payment_method' => ['required', 'in:pix,card'],
        ]);
        $total = $this->getCartTotal(auth()->user());
        session([
            'checkout' => [
            'cpf' => $request->cpf,
            'payment_method' => $request->payment_method,
            'total' => $total,
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

        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'paid',
            ]);

            $total = session('checkout.total');

            foreach ($cart->items as $item) {
                $price = $item->product->price
                    ?? $item->product->price_cents / 100;

                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                $total += $price * $item->quantity;
            }

            $order->update([
                'total_price' => $total,
            ]);

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
            'total' => $checkout['total'],
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
            $price = $item->product->price
                ?? $item->product->price_cents / 100;

            $total += $price * $item->quantity;
        }

        return $total;
    }
}