<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
    public function criarPagamento(Request $request)
    {
        // 1️⃣ Validação
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // 2️⃣ Produto real do banco
        $product = Product::findOrFail($request->product_id);

        // 3️⃣ Token do Mercado Pago
        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.token')
        );

        // 4️⃣ Criação da preferência
        $client = new PreferenceClient();

        $preference = $client->create([
            "items" => [
                [
                    "title" => $product->name,
                    "quantity" => 1,
                    "unit_price" => (float) $product->price,
                ]
            ],
        ]);

        // 5️⃣ Retorna link do Mercado Pago
        return response()->json([
            'init_point' => $preference->init_point,
        ]);
    }
}