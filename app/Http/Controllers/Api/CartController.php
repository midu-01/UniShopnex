<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function show(CartService $cartService): JsonResponse
    {
        $cart = $cartService->current(auth()->user());

        return response()->json([
            'cart' => new CartResource($cart->load('items.product.primaryImage')),
            'totals' => $cartService->totals($cart),
        ]);
    }

    public function store(StoreCartItemRequest $request, CartService $cartService): JsonResponse
    {
        $product = Product::query()->findOrFail($request->integer('product_id'));
        $cart = $cartService->add($request->user(), $product, $request->integer('quantity'));

        return response()->json([
            'message' => 'Item added to cart.',
            'cart' => new CartResource($cart),
            'totals' => $cartService->totals($cart),
        ], 201);
    }

    public function update(StoreCartItemRequest $request, Product $product, CartService $cartService): JsonResponse
    {
        $cart = $cartService->updateQuantity($request->user(), $product, $request->integer('quantity'));

        return response()->json([
            'message' => 'Cart updated.',
            'cart' => new CartResource($cart),
            'totals' => $cartService->totals($cart),
        ]);
    }

    public function destroy(Product $product, CartService $cartService): JsonResponse
    {
        $cart = $cartService->updateQuantity(auth()->user(), $product, 0);

        return response()->json([
            'message' => 'Item removed.',
            'cart' => new CartResource($cart),
            'totals' => $cartService->totals($cart),
        ]);
    }
}
