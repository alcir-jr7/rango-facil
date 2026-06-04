<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteStoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Rotas públicas (SEM login)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => Inertia::render('Landing'))->name('landing');
Route::get('/welcome', fn() => Inertia::render('Welcome'))->name('home');
Route::get('/quem-somos', fn() => Inertia::render('QuemSomos'))->name('quem-somos');
Route::get('/privacidade', fn() => Inertia::render('Privacidade'))->name('privacidade');
Route::get('/codigo-conduta', fn() => Inertia::render('CodigoDeConduta'))->name('codigo-conduta');
Route::get('/cadastre-loja', fn() => Inertia::render('CadastreSuaLoja'))->name('cadastre-loja');
Route::get('/faq', fn() => Inertia::render('Faq'))->name('faq');

/*
|--------------------------------------------------------------------------
| Dashboard
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

    /* Produtos */
    Route::resource('products', ProductController::class)->except(['show']);

    /* Lojas */
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::get('/stores/all', [StoreController::class, 'all'])->name('stores.all');
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');
    Route::post('/stores/{store}/toggle-open', [StoreController::class, 'toggleOpen'])->name('stores.toggleOpen');
    Route::post('/stores/{store}/toggle-auto-confirm', [StoreController::class, 'toggleAutoConfirm'])->name('stores.toggleAutoConfirm');

    /* Favoritos */
    Route::post('/stores/{store}/favorite', [FavoriteStoreController::class, 'store'])->name('stores.favorite');
    Route::delete('/stores/{store}/favorite', [FavoriteStoreController::class, 'destroy'])->name('stores.unfavorite');

    Route::get('/favorites', function () {
        $favorites = auth()->user()
            ->favoriteStores()
            ->get()
            ->map(fn($store) => [
                'id'      => $store->id,
                'name'    => $store->name,
                'is_open' => (bool) ($store->is_open ?? false),
                'image'   => $store->image ?? null,
            ]);

        return Inertia::render('Favorites/Index', ['favorites' => $favorites]);
    })->name('favorites.index');

    /* ─── Pedidos ─── */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/orders/review', [OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/pay', [OrderController::class, 'pay'])->name('orders.pay');

    // Marcar como recebido
    Route::patch('/orders/{order}/delivered', [OrderController::class, 'markDelivered'])->name('orders.delivered');

    // Formulário de avaliação
    Route::get('/orders/{order}/rate', [OrderController::class, 'rateForm'])->name('orders.rate');

    /* ─── Avaliações ─── */
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Avaliações recebidas (painel do lojista)
    Route::get('/my-store/reviews', [ReviewController::class, 'storeReviews'])->name('reviews.store-reviews');

    /* Pagamento */
    Route::post('/pagamento/criar', [PaymentController::class, 'criarPagamento']);

    // Retorno do Mercado Pago (back_urls — funciona só com URL pública)
    Route::get('/pagamento/sucesso',       [PaymentController::class, 'sucesso'])->name('payment.success');
    Route::get('/pagamento/falha',         [PaymentController::class, 'falha'])->name('payment.failure');
    Route::get('/pagamento/pendente',      [PaymentController::class, 'pendente'])->name('payment.pending');
    // Rota manual para ambiente local (após pagar no MP, acesse esta URL para criar o pedido)
    Route::get('/pagamento/confirmar-local', [PaymentController::class, 'sucessoLocal'])->name('payment.local');
});

/*
|--------------------------------------------------------------------------
| STORE PÚBLICA (SHOW)
|--------------------------------------------------------------------------
*/
Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');

/* Carrinho */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');