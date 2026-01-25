<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
}