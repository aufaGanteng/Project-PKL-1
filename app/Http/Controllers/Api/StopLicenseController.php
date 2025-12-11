<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StopLicense;
use Illuminate\Http\Request;

class StopLicenseController extends Controller
{
    public function index()
    {
        $stopLicenses = StopLicense::all();
        
        return response()->json([
            'success' => true,
            'data' => $stopLicenses
        ]);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'number' => 'required|unique:stop_licenses,number',
        'date' => 'required|date',
        'stop_date' => 'required|date',
        'work_order_id' => 'required|exists:work_orders,id',
        'client_id' => 'required|exists:clients,id',
        'product_id' => 'nullable|exists:products,id',
        'client_spv' => 'nullable|string',
        'notes' => 'nullable|string',
        'is_stopped' => 'boolean',
    ]);

    $stopLicense = StopLicense::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Stop License created successfully',
        'data' => $stopLicense
    ], 201);
}



    public function show(StopLicense $stopLicense)
    {
        
        return response()->json([
            'success' => true,
            'data' => $stopLicense
        ]);
    }

   public function update(Request $request, StopLicense $stopLicense)
{
    $validated = $request->validate([
        'number' => 'required|string|max:50|unique:stop_licenses,number,' . $stopLicense->id,
        'date' => 'required|date',
        'stop_date' => 'required|date',
        'work_order_id' => 'required|exists:work_orders,id',
        'client_id' => 'required|exists:clients,id',
        'product_id' => 'nullable|exists:products,id',
        'client_spv' => 'nullable|string',
        'notes' => 'nullable|string',
        'is_stopped' => 'nullable|boolean',
    ]);

    $stopLicense->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Stop License updated successfully',
        'data' => $stopLicense
    ], 200);
}


    public function destroy(Request $request, StopLicense $stopLicense)
    {
        $stopLicense->forcedelete();

        return response()->json([
            'success' => true,
            'message' => 'Stop License deleted successfully',
            'deleted' => true
        ]);
    }
}