<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, CartService $cartService): View
    {
        $user = $request->user();
        $cart = $cartService->current($user);

        return view('customer.dashboard', [
            'user' => $user->load(['orders.items', 'addresses']),
            'cartTotals' => $cartService->totals($cart),
            'recentOrders' => $user->orders()->latest('placed_at')->limit(5)->get(),
        ]);
    }
}
