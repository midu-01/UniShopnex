<?php

namespace App\Http\Controllers\Vendor;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orders,
    ) {
    }

    public function index(Request $request): View
    {
        return view('vendor.orders.index', [
            'orders' => $this->orders->paginateForVendor($request->user()),
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorize('view', $order);

        return view('vendor.orders.show', [
            'order' => $order->load(['user', 'items.product.primaryImage', 'payment']),
        ]);
    }
}
