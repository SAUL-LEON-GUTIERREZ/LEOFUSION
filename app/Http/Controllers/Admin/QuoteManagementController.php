<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignProviderRequest;
use App\Http\Requests\UpdateQuoteStatusRequest;
use App\Models\Order;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteManagementController extends Controller
{
    public function index(): JsonResponse
    {
        $quotes = Quote::with(['user', 'items', 'order.provider'])->latest()->get();

        return response()->json($quotes);
    }

    public function show(Quote $quote): JsonResponse
    {
        return response()->json($quote->load(['user', 'items', 'order.provider']));
    }

    public function updateStatus(UpdateQuoteStatusRequest $request, Quote $quote): JsonResponse
    {
        $quote->update($request->validated());

        return response()->json([
            'message' => 'Estado de cotización actualizado.',
            'quote' => $quote,
        ]);
    }

    public function assignProvider(AssignProviderRequest $request, Quote $quote): JsonResponse
    {
        $order = Order::updateOrCreate(
            ['quote_id' => $quote->id],
            [
                'provider_id' => $request->integer('provider_id'),
                'total' => $request->input('total'),
                'status' => Order::STATUS_EN_GESTION,
            ]
        );

        return response()->json([
            'message' => 'Proveedor asignado correctamente.',
            'order' => $order->load(['provider', 'quote']),
        ]);
    }

    public function convertToOrder(Quote $quote): JsonResponse
    {
        if ($quote->status !== Quote::STATUS_APROBADO) {
            return response()->json([
                'message' => 'Solo cotizaciones aprobadas pueden convertirse en pedido.',
            ], 422);
        }

        $order = $quote->order;

        if (!$order) {
            return response()->json([
                'message' => 'Primero debes asignar un proveedor y total estimado.',
            ], 422);
        }

        $order->update(['status' => Order::STATUS_EN_GESTION]);

        return response()->json([
            'message' => 'Cotización convertida a pedido correctamente.',
            'order' => $order->load(['provider', 'quote']),
        ]);
    }
}
