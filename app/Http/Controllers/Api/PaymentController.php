<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice', 'client'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:payments,number',
            'date' => 'required|date',
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'is_posted' => 'nullable|boolean',
        ]);

        $payment = Payment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully',
            'data' => $payment->load(['invoice', 'client'])
        ], 201);
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'client']);
        
        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'number' => 'required|unique:payments,number,' . $payment->id,
            'date' => 'required|date',
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'is_posted' => 'nullable|boolean',
        ]);

        $payment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment->load(['invoice', 'client'])
        ]);
    }

    public function destroy(Request $request, Payment $payment)
    {
        $force = $request->query('force');
        
        if ($force == 'true' || $force === true) {
            $payment->forceDelete();
            return response()->json([
                'success' => true,
                'message' => 'Payment force-deleted successfully'
            ]);
        }

        $payment->forcedelete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully'
        ]);
    }
}
