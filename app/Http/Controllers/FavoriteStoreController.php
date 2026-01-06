<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

class FavoriteStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Store $store)
    {
        DB::table('favorite_stores')->updateOrInsert(
            [
                'user_id' => auth()->id(),
                'store_id' => $store->id,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back();
    }

    public function destroy(Store $store)
    {
        DB::table('favorite_stores')
            ->where('user_id', auth()->id())
            ->where('store_id', $store->id)
            ->delete();

        return back();
    }
}
