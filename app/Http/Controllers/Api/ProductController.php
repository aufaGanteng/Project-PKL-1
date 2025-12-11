<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required|string',
            'specification' => 'nullable|string',
            'description' => 'nullable|string',
            'author_code' => 'nullable|string',
            'author_name' => 'nullable|string',
            'compiler' => 'nullable|string',
            'year' => 'nullable|digits:4',
            'product_group_id' => 'nullable|exists:product_groups,id',
            'is_active' => 'nullable|boolean',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'name' => 'required|string',
            'specification' => 'nullable|string',
            'description' => 'nullable|string',
            'author_code' => 'nullable|string',
            'author_name' => 'nullable|string',
            'compiler' => 'nullable|string',
            'year' => 'nullable|digits:4',
            'product_group_id' => 'nullable|exists:product_groups,id',
            'is_active' => 'nullable|boolean',
        ]);

        $product->update($validated);
        $product->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
            'was_changed' => $product->wasChanged(),
            'changes' => $product->getChanges()
        ]);
    }

   public function destroy($id)
{
    // Cari data termasuk yang sudah soft delete
    $product = Product::withTrashed()
        ->where('id', $id)
        ->orWhere('code', $id)
        ->first();

    if (! $product) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found',
            'query' => $id
        ], 404);
    }

    try {
        // Hapus permanen dari database
        $product->forceDelete();
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to permanently delete product',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Product permanently deleted from database'
    ], 200);
}

}