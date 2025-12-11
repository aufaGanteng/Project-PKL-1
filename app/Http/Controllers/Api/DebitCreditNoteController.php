<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DebitCreditNote;
use Illuminate\Http\Request;

class DebitCreditNoteController extends Controller
{
    public function index()
    {
        $notes = DebitCreditNote::with(['invoice', 'client'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $notes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:D,C',
            'number' => 'required|unique:debit_credit_notes,number',
            'date' => 'required|date',
            'invoice_id' => 'nullable|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'dpp_amount' => 'nullable|numeric',
            'ppn_amount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'auto_journal' => 'nullable|boolean',
            'is_posted' => 'nullable|boolean',
        ]);

        $note = DebitCreditNote::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Debit/Credit Note created successfully',
            'data' => $note->load(['invoice', 'client'])
        ], 201);
    }

    public function show(DebitCreditNote $debitCreditNote)
    {
        $debitCreditNote->load(['invoice', 'client']);
        
        return response()->json([
            'success' => true,
            'data' => $debitCreditNote
        ]);
    }

    public function update(Request $request, DebitCreditNote $debitCreditNote)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:D,C',
            'number' => 'required|unique:debit_credit_notes,number,' . $debitCreditNote->id,
            'date' => 'required|date',
            'invoice_id' => 'nullable|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'dpp_amount' => 'nullable|numeric',
            'ppn_amount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'auto_journal' => 'nullable|boolean',
            'is_posted' => 'nullable|boolean',
        ]);

        $debitCreditNote->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Debit/Credit Note updated successfully',
            'data' => $debitCreditNote->load(['invoice', 'client'])
        ]);
    }

    public function destroy(Request $request, DebitCreditNote $debitCreditNote)
    {
        $force = $request->query('force');

        if ($force == 'true' || $force === true) {
            $debitCreditNote->forceDelete();
            return response()->json([
                'success' => true,
                'message' => 'Debit/Credit Note force-deleted successfully',
                'deleted' => true
            ]);
        }

        $debitCreditNote->forcedelete();

        return response()->json([
            'success' => true,
            'message' => 'Debit/Credit Note deleted successfully'
        ]);
    }
}
