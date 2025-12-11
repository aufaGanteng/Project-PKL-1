<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $Bank = Bank::all();
        
        return response()->json([
            'success' => true,
            'data' => $Bank
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:banks',
            'name' => 'required|string',
            'account_number' => 'nullable|string',
            'account_name' => 'nullable|string',
            'type' => 'nullable|in:M,S',
            'acc_code' => 'nullable|string',
            'cdf_code' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $bank = Bank::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Bank created successfully',
        'data' => $bank
    ], 201);
}

    public function show(Bank $Bank)
    {
        return response()->json([
            'success' => true,
            'data' => $Bank
        ]);
    }

    public function update(Request $request, Bank $Bank)
    {
        $validated = $request->validate([
            'code' => 'required|unique:banks,code,' . $Bank->id,
            'name' => 'required|string',
            'account_number' => 'nullable|string',
            'account_name' => 'nullable|string',
            'type' => 'nullable|in:M,S',
            'acc_code' => 'nullable|string',
            'cdf_code' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $Bank->update($validated);
        $Bank->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Bank updated successfully',
            'data' => $Bank,
            'was_changed' => $Bank->wasChanged(),
            'changes' => $Bank->getChanges()
        ]);
    }

    public function destroy($id)
{
    // Find bank even if already soft deleted
    $bank = Bank::withTrashed()
        ->where('id', $id)
        ->orWhere('code', $id)
        ->first();

    if (! $bank) {
        return response()->json([
            'success' => false,
            'message' => 'Bank not found',
            'query' => $id
        ], 404);
    }

    try {
        // Force delete permanently from database
        $bank->forceDelete();
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to permanently delete bank',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Bank permanently deleted from database'
    ], 200);
}

}