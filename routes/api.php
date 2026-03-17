<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\QuoteManagementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientQuoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:sanctum', 'role:cliente,profesional'])->group(function (): void {
    Route::post('quotes', [ClientQuoteController::class, 'store']);
    Route::get('quotes', [ClientQuoteController::class, 'index']);
    Route::get('quotes/{quote}', [ClientQuoteController::class, 'show']);
    Route::post('quotes/{quote}/approve', [ClientQuoteController::class, 'approve']);
});

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function (): void {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('providers', ProviderController::class);

        Route::get('quotes', [QuoteManagementController::class, 'index']);
        Route::get('quotes/{quote}', [QuoteManagementController::class, 'show']);
        Route::patch('quotes/{quote}/status', [QuoteManagementController::class, 'updateStatus']);
        Route::post('quotes/{quote}/assign-provider', [QuoteManagementController::class, 'assignProvider']);
        Route::post('quotes/{quote}/convert-to-order', [QuoteManagementController::class, 'convertToOrder']);

        Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'update']);
        Route::get('reports/overview', [OrderController::class, 'overview']);
    });
