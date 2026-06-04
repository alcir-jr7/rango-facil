<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class PaymentController extends Controller
{
    public function criarPagamento(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::with('store')->findOrFail($request->product_id);
        $user    = auth()->user();

        $externalReference = 'rf-' . $user->id . '-' . $product->id . '-' . Str::random(8);

        session([
            'mp_pending' => [
                'external_reference' => $externalReference,
                'product_id'         => $product->id,
                'store_id'           => $product->store_id,
                'price'              => (float) $product->price,
                'user_id'            => $user->id,
            ],
        ]);

        try {
            MercadoPagoConfig::setAccessToken(
                config('services.mercadopago.token')
            );

            $client  = new PreferenceClient();
            $appUrl  = rtrim(config('app.url'), '/');
            $isLocal = app()->environment('local')
                || str_contains($appUrl, 'localhost')
                || str_contains($appUrl, '127.0.0');

            $preferenceData = [
                'items' => [
                    [
                        'title'      => $product->name,
                        'quantity'   => 1,
                        'unit_price' => (float) $product->price,
                    ],
                ],
                'external_reference' => $externalReference,
            ];

            // back_urls só funcionam com URL pública (não localhost)
            if (!$isLocal) {
                $preferenceData['back_urls'] = [
                    'success' => $appUrl . '/pagamento/sucesso',
                    'failure' => $appUrl . '/pagamento/falha',
                    'pending' => $appUrl . '/pagamento/pendente',
                ];
                $preferenceData['auto_return'] = 'approved';
            }

            $preference = $client->create($preferenceData);

            return response()->json([
                'init_point' => $preference->init_point,
            ]);

        } catch (MPApiException $e) {
            $apiResponse = $e->getApiResponse();
            $body        = $apiResponse ? $apiResponse->getContent() : [];

            Log::error('MercadoPago MPApiException', [
                'message' => $e->getMessage(),
                'status'  => $apiResponse?->getStatusCode(),
                'body'    => $body,
                'product' => $product->id,
                'price'   => $product->price,
            ]);

            return response()->json([
                'message'  => 'Erro ao criar pagamento.',
                'mp_error' => $body,
            ], 422);

        } catch (\Exception $e) {
            Log::error('MercadoPago Exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Erro inesperado: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retorno automático do MP em produção (back_url success).
     */
    public function sucesso(Request $request)
    {
        $pending = session('mp_pending');

        if (
            $pending &&
            $request->get('external_reference') === $pending['external_reference']
        ) {
            $this->criarPedidoDoPagamento($pending, $request->get('payment_id'));
            session()->forget('mp_pending');
        }

        return inertia('Orders/PaymentSuccess', ['isLocal' => false]);
    }

    /**
     * Em localhost: cliente volta do MP e cai aqui.
     * Cria o pedido e mostra a tela de sucesso.
     */
    public function sucessoLocal()
    {
        $pending = session('mp_pending');

        if ($pending) {
            $this->criarPedidoDoPagamento($pending, null);
            session()->forget('mp_pending');
        }

        return inertia('Orders/PaymentSuccess', ['isLocal' => true]);
    }

    public function falha()
    {
        session()->forget('mp_pending');

        return redirect()
            ->route('dashboard')
            ->with('error', 'Pagamento não aprovado. Tente novamente.');
    }

    public function pendente()
    {
        session()->forget('mp_pending');

        return redirect()
            ->route('orders.index')
            ->with('info', 'Seu pagamento está sendo processado. Aguarde a confirmação.');
    }

    private function criarPedidoDoPagamento(array $pending, ?string $paymentId): void
    {
        $exists = Order::where('external_reference', $pending['external_reference'])->exists();
        if ($exists) return;

        DB::transaction(function () use ($pending, $paymentId) {
            $order = Order::create([
                'user_id'            => $pending['user_id'],
                'store_id'           => $pending['store_id'],
                'total_price'        => $pending['price'],
                'status'             => 'paid',
                'external_reference' => $pending['external_reference'],
                'mp_payment_id'      => $paymentId,
            ]);

            $order->products()->attach($pending['product_id'], [
                'quantity' => 1,
                'price'    => $pending['price'],
            ]);
        });
    }
}