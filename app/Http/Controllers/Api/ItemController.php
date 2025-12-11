<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:items',
            'name' => 'required|string',
            'acc_omzet' => 'nullable|string',
            'acc_piutang' => 'nullable|string',
            'cdf_omzet' => 'nullable|string',
            'cdf_piutang' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $item = Item::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = Item::with('invoiceItems')->find($id);

        if (! $item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (! $item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }

        $validated = $request->validate([
            'code' => 'required|unique:items,code,' . $item->id,
            'name' => 'required|string',
            'acc_omzet' => 'nullable|string',
            'acc_piutang' => 'nullable|string',
            'cdf_omzet' => 'nullable|string',
            'cdf_piutang' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $item->update($validated);
        $item->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'data' => $item,
            'was_changed' => $item->wasChanged(),
            'changes' => $item->getChanges()
        ]);
    }

    public function destroy($id)
    {
        // ambil item, termasuk yang sudah soft delete
        $item = Item::withTrashed()
            ->where('id', $id)
            ->orWhere('code', $id)
            ->first();

        if (! $item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
                'query' => $id
            ], 404);
        }

        try {
            // hapus permanent dari database
            $item->forceDelete();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to permanently delete item',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item permanently deleted from database'
        ], 200);
    }
}
