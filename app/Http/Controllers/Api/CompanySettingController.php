<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function show()
    {
        $setting = CompanySetting::first();

        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    public function update(Request $request)
    {
        $setting = CompanySetting::first() ?? new CompanySetting();

        $validated = $request->validate([
            'logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'company_name' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'npwp' => 'nullable|string',
            'period_start' => 'nullable|date',

            'acc_ppn_kes' => 'nullable|string',
            'acc_ppn_mas' => 'nullable|string',
            'acc_discount' => 'nullable|string',

            'bank1' => 'nullable|string',
            'bank1_sn' => 'nullable|string',
            'bank1_ac' => 'nullable|string',

            'bank2' => 'nullable|string',
            'bank2_sn' => 'nullable|string',
            'bank2_ac' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $validated['logo'] = $request->file('logo')->store('company_logo', 'public');
        }

        $setting->fill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Company settings updated successfully',
            'data' => $setting
        ]);
    }
}
