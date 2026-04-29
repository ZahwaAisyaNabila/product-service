<?php

use Illuminate\Support\Facades\Route;

// halaman utama
Route::get('/', function () {
    return view('welcome');
});

// test browser biasa
Route::get('/test', function () {
    return response()->json([
        'message' => 'Web route aktif'
    ]);
});

// halaman products biasa (opsional)
Route::get('/products', function () {
    return response()->json([
        'message' => 'Halaman products web route'
    ]);
});

// detail product web biasa (opsional)
Route::get('/products/{id}', function ($id) {
    return response()->json([
        'message' => 'Detail product web route',
        'id' => $id
    ]);
});
