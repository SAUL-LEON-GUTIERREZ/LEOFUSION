<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientQuoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $quotes = Quote::with(['items', 'order'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($quotes);
    }

    public function show(Request $request, Quote $quote): JsonResponse
    {
        abort_if($quote->user_id !== $request->user()->id, 403, 'No autorizado.');

        return response()->json($quote->load(['items', 'order.provider']));
    }

    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $data = $request->validated();

        $quote = Quote::create([
            'user_id' => $request->user()->id,
            'location' => $data['location'],
            'project_type' => $data['project_type'],
            'message' => $data['message'] ?? null,
            'status' => Quote::STATUS_PENDIENTE,
            'total_estimated' => null,
        ]);

        $quote->items()->createMany($data['items']);

        return response()->json([
            'message' => 'Cotización registrada correctamente.',
            'quote' => $quote->load('items'),
        ], 201);
    }

    public function approve(Request $request, Quote $quote): JsonResponse
    {
        abort_if($quote->user_id !== $request->user()->id, 403, 'No autorizado.');
        abort_if($quote->status !== Quote::STATUS_COTIZADO, 422, 'La cotización no está lista para aprobar.');

        $quote->update(['status' => Quote::STATUS_APROBADO]);

        return response()->json([
            'message' => 'Cotización aprobada. Se iniciará la gestión del pedido.',
            'quote' => $quote,
        ]);
    }
}
