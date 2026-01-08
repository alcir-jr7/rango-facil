<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class FavoriteStoreController extends Controller
{
    /**
     * Favoritar uma loja
     */
    public function store(Store $store)
    {
        $user = auth()->user();
        
        // Adiciona aos favoritos se ainda não estiver
        if (!$user->favoriteStores()->where('store_id', $store->id)->exists()) {
            $user->favoriteStores()->attach($store->id);
        }

        return redirect()->back();
    }

    /**
     * Desfavoritar uma loja
     */
    public function destroy(Store $store)
    {
        auth()->user()->favoriteStores()->detach($store->id);

        return redirect()->back();
    }
}