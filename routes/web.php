<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteStoreController;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard (usuário logado)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Auth / Settings
|--------------------------------------------------------------------------
*/
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rotas protegidas (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Produtos
    |--------------------------------------------------------------------------
    */
    Route::resource('products', ProductController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Lojas
    |--------------------------------------------------------------------------
    */
    Route::resource('stores', StoreController::class);

    Route::post('/stores/{store}/toggle-open', [StoreController::class, 'toggleOpen'])
        ->name('stores.toggleOpen');

    Route::post('/stores/{store}/toggle-auto-confirm', [StoreController::class, 'toggleAutoConfirm'])
        ->name('stores.toggleAutoConfirm');

    /*
    |--------------------------------------------------------------------------
    | Favoritos
    |--------------------------------------------------------------------------
    */

    // Favoritar loja
    Route::post('/stores/{store}/favorite', [FavoriteStoreController::class, 'store'])
        ->name('stores.favorite');

    // Desfavoritar loja
    Route::delete('/stores/{store}/favorite', [FavoriteStoreController::class, 'destroy'])
        ->name('stores.unfavorite');

    // Página de favoritos
    Route::get('/favorites', function () {
        $favorites = auth()->user()
            ->favoriteStores()
            ->get()
            ->map(function($store) {
                return [
                    'id' => $store->id,
                    'name' => $store->name,
                    'is_open' => (bool) ($store->is_open ?? false),
                    'image' => $store->image ?? null,
                ];
            });

        return Inertia::render('Favorites/Index', [
            'favorites' => $favorites
        ]);
    })->name('favorites.index');

});