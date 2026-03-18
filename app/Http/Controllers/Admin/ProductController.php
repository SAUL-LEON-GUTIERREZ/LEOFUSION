<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::with('category')->latest()->get());
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('technical_sheet')) {
            $data['technical_sheet'] = $request->file('technical_sheet')->store('technical-sheets');
        }

        $product = Product::create($data);

        return response()->json($product->load('category'), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('category'));
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('technical_sheet')) {
            $data['technical_sheet'] = $request->file('technical_sheet')->store('technical-sheets');
        }

        $product->update($data);

        return response()->json($product->load('category'));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(status: 204);
    }
}
