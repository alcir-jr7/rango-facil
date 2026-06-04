<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Salva nova avaliação.
     */
    public function store(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'delivered', 422, 'Só é possível avaliar pedidos entregues.');
        abort_if($order->review !== null, 422, 'Pedido já foi avaliado.');

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::create([
            'order_id' => $order->id,
            'user_id'  => auth()->id(),
            'store_id' => $order->store_id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Avaliação enviada com sucesso! Obrigado pelo feedback.');
    }

    /**
     * Atualiza avaliação existente.
     */
    public function update(Request $request, Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove avaliação.
     */
    public function destroy(Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        $review->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Avaliação removida.');
    }

    /**
     * Avaliações recebidas pelo dono da loja.
     */
    public function storeReviews()
    {
        $user = auth()->user();

        // Busca as lojas do usuário
        $reviews = Review::with(['order', 'user'])
            ->whereHas('store', fn($q) => $q->where('owner_id', $user->id))
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($r) => [
                'id'         => $r->id,
                'rating'     => $r->rating,
                'comment'    => $r->comment,
                'created_at' => $r->created_at->format('d/m/Y'),
                'user'       => ['name' => $r->user->name],
                'order_id'   => $r->order_id,
            ]);

        $avgRating = $reviews->avg('rating');

        return inertia('Reviews/StoreReviews', [
            'reviews'    => $reviews,
            'avgRating'  => round($avgRating, 1),
        ]);
    }
}
