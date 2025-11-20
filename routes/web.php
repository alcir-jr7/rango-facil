<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', [StoreController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Rotas de produtos (sem index)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Rotas de Stores protegidas pelo middleware auth
Route::middleware(['auth'])->group(function () {
    Route::resource('stores', StoreController::class)->names('stores');

    Route::post('/stores/{store}/toggle-open', [StoreController::class, 'toggleOpen'])->name('stores.toggleOpen');
    Route::post('/stores/{store}/toggle-auto-confirm', [StoreController::class, 'toggleAutoConfirm'])->name('stores.toggleAutoConfirm');
   

});
