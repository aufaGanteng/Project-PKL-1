<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with(['client'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $workOrders
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'number' => 'nullable|string',
        'date' => 'required|date',
        'date_install' => 'required|date',
        'start_license' => 'nullable|date',
        'client_id' => 'required|exists:clients,id',
        'product_id' => 'nullable|exists:products,id',
        'item_id' => 'nullable|exists:items,id',
        'status' => 'nullable|string',
        'amount' => 'nullable|numeric',
        'description' => 'nullable|string',
        'item_count' => 'nullable|integer',
        'per_unit' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);

    if (!$request->number) {
        $validated['number'] = 'WO-' . str_pad((WorkOrder::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
    }

    $workOrder = WorkOrder::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Work Order created successfully',
        'data' => $workOrder->load('client')
    ], 201);
}


    public function show($id)
{
    $workOrder = WorkOrder::with(['client', 'product', 'item'])->find($id);

    if (! $workOrder) {
        return response()->json([
            'success' => false,
            'message' => 'Work Order not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $workOrder
    ]);
}


    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'number' => 'required|unique:work_orders,number,' . $workOrder->id,
            'date' => 'required|date',
            'date_install' => 'required|date',
            'start_license' => 'nullable|date',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'nullable|exists:products,id',
            'item_id' => 'nullable|exists:items,id',
            'status' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'item_count' => 'nullable|integer',
            'per_unit' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $workOrder->update($validated);
        $workOrder->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Work Order updated successfully',
            'data' => $workOrder->load('client'),
            'was_changed' => $workOrder->wasChanged(),
            'changes' => $workOrder->getChanges()
        ]);
    }

    public function destroy($id)
{
    $workOrder = WorkOrder::withTrashed()
        ->where('id', $id)
        ->orWhere('number', $id)
        ->first();

    if (! $workOrder) {
        return response()->json([
            'success' => false,
            'message' => 'Work Order not found',
            'query' => $id
        ], 404);
    }

    try {
        $workOrder->forceDelete();
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to permanently delete Work Order',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Work Order permanently deleted from database'
    ], 200);
}

}