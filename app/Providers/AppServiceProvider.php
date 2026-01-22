<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Cart;
use App\Models\Store;
use App\Policies\StorePolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ Policy da Store
        Gate::policy(Store::class, StorePolicy::class);

        // ✅ Compartilhar cartCount com Inertia
        Inertia::share('cartCount', function () {
            $user = auth()->user();

            if (!$user) {
                return 0;
            }

            $cart = Cart::where('user_id', $user->id)
                ->with('items')
                ->first();

            if (!$cart) {
                return 0;
            }

            return $cart->items->count();
        });
    }
}
