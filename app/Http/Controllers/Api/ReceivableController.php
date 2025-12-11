<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receivable;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
    {
        $receivables = Receivable::with(['client', 'invoice'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $receivables
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|string|max:7',
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'client_code' => 'required|string|max:20',
            'client_name' => 'required|string',
            'beginning_balance' => 'nullable|numeric',
            'netto' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'biaya' => 'nullable|numeric',
            'nota_debet' => 'nullable|numeric',
            'payment' => 'nullable|numeric',
            'ending_balance' => 'nullable|numeric',
            'status' => 'nullable|string|max:20',
        ]);

        $receivable = Receivable::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Receivable created successfully',
            'data' => $receivable->load(['client', 'invoice'])
        ], 201);
    }

    public function show(Receivable $receivable)
    {
        $receivable->load(['client', 'invoice']);
        
        return response()->json([
            'success' => true,
            'data' => $receivable
        ]);
    }

    public function update(Request $request, Receivable $receivable)
    {
        $validated = $request->validate([
            'period' => 'required|string|max:7',
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'client_code' => 'required|string|max:20',
            'client_name' => 'required|string',
            'beginning_balance' => 'nullable|numeric',
            'netto' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'biaya' => 'nullable|numeric',
            'nota_debet' => 'nullable|numeric',
            'payment' => 'nullable|numeric',
            'ending_balance' => 'nullable|numeric',
            'status' => 'nullable|string|max:20',
        ]);

        $receivable->update($validated);
        $receivable->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Receivable updated successfully',
            'data' => $receivable->load(['client', 'invoice'])
        ]);
    }

    public function destroy(Receivable $receivable)
    {
        $receivable->forcedelete();

        return response()->json([
            'success' => true,
            'message' => 'Receivable deleted successfully',
            'deleted' => true
        ]);
    }
}
