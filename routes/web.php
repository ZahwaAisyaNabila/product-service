<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// TEST
Route::get('/test', function () {
    return "Web route jalan";
});

// GET semua produk
Route::get('/products', function () {
    return response()->json([
        [
            "id" => 1,
            "name" => "Laptop",
            "price" => 10000000,
            "stock" => 5
        ],
        [
            "id" => 2,
            "name" => "Mouse",
            "price" => 200000,
            "stock" => 10
        ]
    ]);
});

// GET produk by ID
Route::get('/products/{id}', function ($id) {
    return response()->json([
        "id" => $id,
        "name" => "Produk " . $id,
        "price" => 500000,
        "stock" => 20
    ]);
});

// POST tambah produk
Route::post('/products', function (Request $request) {
    return response()->json([
        "message" => "Produk berhasil ditambahkan",
        "data" => $request->all()
    ]);
});
