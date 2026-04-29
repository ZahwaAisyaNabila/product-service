<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ProductController extends Controller
{
    protected $userServiceUrl = 'http://127.0.0.1:8001/api';

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'message' => 'Daftar semua produk',
            'data'    => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json([
            'message' => 'Detail produk',
            'data'    => $product
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|numeric',
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        try {
            $userResponse = Http::timeout(5)->get("{$this->userServiceUrl}/users/{$request->user_id}");
            if ($userResponse->failed() || $userResponse->status() === 404) {
                return response()->json([
                    'message' => 'User tidak ditemukan di UserService',
                    'user_id' => $request->user_id
                ], 404);
            }
            $userData = $userResponse->json();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'UserService tidak dapat dihubungi',
                'error'   => $e->getMessage()
            ], 503);
        }

        $product = Product::create([
            'user_id'     => $request->user_id,
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description ?? null,
        ]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data'    => $product,
            'seller'  => $userData
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        $product->update($request->all());
        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data'    => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }

    public function showWithSeller($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        try {
            $userResponse = Http::timeout(5)->get("{$this->userServiceUrl}/users/{$product->user_id}");
            $seller = $userResponse->successful() ? $userResponse->json() : null;
        } catch (\Exception $e) {
            $seller = null;
        }
        return response()->json([
            'message' => 'Detail produk dengan data seller',
            'data'    => $product,
            'seller'  => $seller
        ]);
    }

    public function reduceStock(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        $request->validate(['quantity' => 'required|integer|min:1']);
        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Stok tidak cukup',
                'stock'   => $product->stock
            ], 400);
        }
        $product->stock -= $request->quantity;
        $product->save();
        return response()->json([
            'message' => 'Stok berhasil dikurangi',
            'data'    => $product
        ]);
    }
}
