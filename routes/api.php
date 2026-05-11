<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API User Service ShopEase berjalan',
        'service' => 'UserService',
        'port'    => '8001'
    ]);
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}/orders', [UserController::class, 'getUserOrders']);
