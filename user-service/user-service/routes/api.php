<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// =============================================
// TEST
// =============================================
Route::get('/test', function () {
    return response()->json([
        'message' => 'API User Service ShopEase berjalan',
        'service' => 'UserService',
        'port'    => '8001'
    ]);
});

// =============================================
// PROVIDER: Menyediakan data user untuk service lain
// =============================================
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);

// =============================================
// CONSUMER: Mengambil data order dari OrderService
// =============================================
Route::get('/users/{id}/orders', [UserController::class, 'getUserOrders']);
