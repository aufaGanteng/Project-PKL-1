<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\WorkOrderController;
use App\Http\Controllers\Api\InstallationController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceItemController;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\StopLicenseController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\DebitCreditNoteController;
use App\Http\Controllers\Api\ReceivableController;
use App\Http\Controllers\Api\ProtectionController;

// Public Routes (Gak butuh token)
Route::post('/login', [AuthController::class, 'login']);

// Test Route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});

// Protected Routes (Butuh token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // API Resource Routes
    Route::get('/clients/search', [ClientController::class, 'search']);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('team-members', TeamMemberController::class);
    Route::apiResource('banks', BankController::class);
    Route::apiResource('work-orders', WorkOrderController::class);
    Route::apiResource('installations', InstallationController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('invoice-items', InvoiceItemController::class);
    Route::apiResource('licenses', LicenseController::class);
    Route::apiResource('stop-licenses', StopLicenseController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('debit-credit-notes', DebitCreditNoteController::class);
    Route::apiResource('receivables', ReceivableController::class);
    Route::apiResource('protections', ProtectionController::class);

});