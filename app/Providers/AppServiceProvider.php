<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share('cartCount', function () {
            $user = auth()->user();

            if (!$user) {
                return 0;
            }

            $cart = Cart::where('user_id', $user->id)->with('items')->first();

            if (!$cart) {
                return 0;
            }

            return $cart->items->count();
        });
    }
}
