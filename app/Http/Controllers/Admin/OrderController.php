<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Order::with(['provider', 'quote.user'])->latest()->get());
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load(['provider', 'quote.user', 'quote.items']));
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order->update($request->validated());

        return response()->json($order->load(['provider', 'quote']));
    }

    public function overview(): JsonResponse
    {
        return response()->json([
            'quotes' => [
                'pendientes' => Quote::where('status', Quote::STATUS_PENDIENTE)->count(),
                'cotizadas' => Quote::where('status', Quote::STATUS_COTIZADO)->count(),
                'aprobadas' => Quote::where('status', Quote::STATUS_APROBADO)->count(),
                'rechazadas' => Quote::where('status', Quote::STATUS_RECHAZADO)->count(),
            ],
            'orders' => [
                'en_gestion' => Order::where('status', Order::STATUS_EN_GESTION)->count(),
                'despachados' => Order::where('status', Order::STATUS_DESPACHADO)->count(),
                'entregados' => Order::where('status', Order::STATUS_ENTREGADO)->count(),
                'monto_total' => Order::sum('total'),
            ],
        ]);
    }
}
