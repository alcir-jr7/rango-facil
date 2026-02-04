<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (!$cart) {
            return inertia('Cart/Index', [
                'items' => [],
                'total' => 0,
            ]);
        }

        $items = $cart->items->map(function ($item) {
            $price = $item->product->price ?? 0;

            return [
                'id'        => $item->product->id,
                'name'      => $item->product->name,
                'price'       => (float) $item->unit_price,
                'price_type'  => $item->price_type, 
                'quantity'  => $item->quantity,
                'subtotal'    => $item->subtotal, 
                'image'     => $item->product->image_path,
            ];
        });

        return inertia('Cart/Index', [
            'items' => $items,
            'total' => $cart->total,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $priceType = $request->input('price_type', 'normal');

        $unitPrice = $priceType === 'minimo' && $product->min_price
            ? $product->min_price
            : $product->price;

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('price_type', $priceType)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => 1,
                'price'      => $unitPrice,
                'price_type' => $priceType,
                'unit_price' => $unitPrice,
            ]);
        }

        return back();
    }

    public function decrease(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return back();
        }

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
        }

        return back();
    }

    public function remove(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()
                ->where('product_id', $product->id)
                ->delete();
        }

        return back();
    }

    public function clear()
    {
        $cart = auth()->user()->cart;

        if ($cart) {
            $cart->items()->delete();
        }

        return back();
    }
}