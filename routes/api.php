<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/stores/statuses', [StoreController::class, 'statuses']);
    Route::post('/stores/{store}/toggle-status', [StoreController::class, 'toggleStatus']);
});
