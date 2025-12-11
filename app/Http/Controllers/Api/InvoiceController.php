<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['client', 'invoiceType'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:invoices',
            'invoice_type_id' => 'required|exists:invoice_types,id',
            'client_id' => 'required|exists:clients,id',
            'bank_id' => 'nullable|exists:banks,id',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'tax_date' => 'nullable|date',
            'tax_number' => 'nullable|string',
            'client_address' => 'nullable|string',
            'description' => 'nullable|string',
            'invoice_category' => 'nullable|string',
            'tax_type' => 'nullable|string',
            'instance' => 'nullable|string',
            'bruto' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'dpp' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'ppn_percentage' => 'nullable|numeric',
            'dp' => 'nullable|numeric',
            'other' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'include_ppn' => 'nullable|boolean',
            'use_old_letterhead' => 'nullable|boolean',
            'auto_journal' => 'nullable|boolean',
            'pass_protelasi' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'is_posted' => 'nullable|boolean',
            'posted_date' => 'nullable|date',
        ]);

        $invoice = Invoice::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully',
            'data' => $invoice->load(['client', 'invoiceType'])
        ], 201);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'invoiceType', 'workOrder', 'items', 'payments']);
        
        return response()->json([
            'success' => true,
            'data' => $invoice
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'number' => 'required|unique:invoices,number,' . $invoice->id,
            'invoice_type_id' => 'required|exists:invoice_types,id',
            'client_id' => 'required|exists:clients,id',
            'bank_id' => 'nullable|exists:banks,id',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'tax_date' => 'nullable|date',
            'tax_number' => 'nullable|string',
            'client_address' => 'nullable|string',
            'description' => 'nullable|string',
            'invoice_category' => 'nullable|string',
            'tax_type' => 'nullable|string',
            'instance' => 'nullable|string',
            'bruto' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'dpp' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'ppn_percentage' => 'nullable|numeric',
            'dp' => 'nullable|numeric',
            'other' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'include_ppn' => 'nullable|boolean',
            'use_old_letterhead' => 'nullable|boolean',
            'auto_journal' => 'nullable|boolean',
            'pass_protelasi' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'is_posted' => 'nullable|boolean',
            'posted_date' => 'nullable|date',
        ]);

        $invoice->update($validated);
        $invoice->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully',
            'data' => $invoice->load(['client', 'invoiceType']),
            'was_changed' => $invoice->wasChanged(),
            'changes' => $invoice->getChanges()
        ]);
    }

    public function destroy(Request $request, Invoice $invoice)
{
    try {
        $invoice->forceDelete(); // langsung hapus permanen
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete invoice permanently',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Invoice permanently deleted',
        'deleted' => true
    ]);
}

}