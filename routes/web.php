<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteStoreController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Rotas públicas (SEM login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Landing');
})->name('landing');

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/quem-somos', function () {
    return Inertia::render('QuemSomos');
})->name('quem-somos');

Route::get('/privacidade', function () {
    return Inertia::render('Privacidade');
})->name('privacidade');

Route::get('/codigo-conduta', function () {
    return Inertia::render('CodigoDeConduta');
})->name('codigo-conduta');

Route::get('/cadastre-loja', function () {
    return Inertia::render('CadastreSuaLoja');
})->name('cadastre-loja');

Route::get('/faq', function () {
    return Inertia::render('Faq');
})->name('faq');


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
require __DIR__ . '/auth.php';
require __DIR__ . '/settings.php';

/*
|--------------------------------------------------------------------------
| Rotas protegidas (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    | Produtos
    */
    Route::resource('products', ProductController::class)->except(['show']);

    /*
    | Lojas (CRUD COMPLETO, EXCETO SHOW) 
    | ⚠️ IMPORTANTE: Colocar rotas específicas ANTES do resource
    */
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');

    Route::post('/stores/{store}/toggle-open', [StoreController::class, 'toggleOpen'])
        ->name('stores.toggleOpen');

    Route::post('/stores/{store}/toggle-auto-confirm', [StoreController::class, 'toggleAutoConfirm'])
        ->name('stores.toggleAutoConfirm');

    /*
    | Favoritos
    */
    Route::post('/stores/{store}/favorite', [FavoriteStoreController::class, 'store'])
        ->name('stores.favorite');

    Route::delete('/stores/{store}/favorite', [FavoriteStoreController::class, 'destroy'])
        ->name('stores.unfavorite');

    Route::get('/favorites', function () {
        $favorites = auth()->user()
            ->favoriteStores()
            ->get()
            ->map(function ($store) {
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

/*
|--------------------------------------------------------------------------
| STORE PÚBLICA (SHOW) - Deve vir DEPOIS das rotas autenticadas
|--------------------------------------------------------------------------
*/
Route::get('/stores/{store}', [StoreController::class, 'show'])
    ->name('stores.show');

/*
|--------------------------------------------------------------------------
| Carrinho
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');