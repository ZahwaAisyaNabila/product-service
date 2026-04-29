<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// TEST
Route::get('/test', function () {
    return response()->json([
        'message' => 'API Product Service ShopEase berjalan',
        'service' => 'ProductService',
        'port'    => '8002'
    ]);
});

// PROVIDER
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/products/{id}/reduce-stock', [ProductController::class, 'reduceStock']);

// CONSUMER
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}/with-seller', [ProductController::class, 'showWithSeller']);
