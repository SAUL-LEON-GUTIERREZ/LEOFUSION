<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;

class ProviderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Provider::latest()->get());
    }

    public function store(ProviderRequest $request): JsonResponse
    {
        $provider = Provider::create($request->validated());

        return response()->json($provider, 201);
    }

    public function show(Provider $provider): JsonResponse
    {
        return response()->json($provider);
    }

    public function update(ProviderRequest $request, Provider $provider): JsonResponse
    {
        $provider->update($request->validated());

        return response()->json($provider);
    }

    public function destroy(Provider $provider): JsonResponse
    {
        $provider->delete();

        return response()->json(status: 204);
    }
}
