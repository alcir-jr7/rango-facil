<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // TODAS as lojas + flag favorita
        $stores = Store::leftJoin('favorite_stores', function ($join) use ($userId) {
                $join->on('stores.id', '=', 'favorite_stores.store_id')
                     ->where('favorite_stores.user_id', $userId);
            })
            ->select(
                'stores.*',
                DB::raw('CASE WHEN favorite_stores.id IS NULL THEN 0 ELSE 1 END as is_favorited')
            )
            ->orderByDesc('is_favorited')
            ->get();

        // ✅ PRODUTOS (PEGANDO TODOS)
        $products = Product::select(
                'id',
                'store_id',
                'name',
                'description',
                'image_path',
                'price',
                'min_price'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', [
            'stores' => $stores,
            'products' => $products, 
        ]);
    }
}