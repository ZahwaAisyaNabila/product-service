<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            ["id" => 1, "name" => "Laptop", "price" => 10000000],
            ["id" => 2, "name" => "Mouse", "price" => 200000]
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            "message" => "Produk berhasil ditambahkan",
            "data" => $request->all()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            "id" => $id,
            "name" => "Produk " . $id
        ]);
    }
}
