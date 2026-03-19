<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orders,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return OrderResource::collection($this->orders->paginateForUser($request->user()));
    }

    public function store(StoreOrderRequest $request, CheckoutService $checkoutService): JsonResponse
    {
        $address = $request->user()->addresses()->findOrFail($request->integer('address_id'));
        $order = $checkoutService->placeOrder($request->user(), $address, $request->validated());

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => new OrderResource($order),
        ], 201);
    }

    public function show(Request $request, Order $order): OrderResource
    {
        $this->authorize('view', $order);

        return new OrderResource($order->load('items.product.primaryImage'));
    }
}
