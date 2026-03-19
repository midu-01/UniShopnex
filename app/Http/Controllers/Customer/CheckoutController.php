<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCheckoutRequest;
use App\Models\Address;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request, CartService $cartService): View
    {
        $cart = $cartService->current($request->user());

        return view('customer.checkout', [
            'cart' => $cart,
            'totals' => $cartService->totals($cart),
            'addresses' => $request->user()->addresses()->latest()->get(),
        ]);
    }

    public function store(StoreCheckoutRequest $request, CheckoutService $checkoutService): RedirectResponse
    {
        $address = $request->user()->addresses()->findOrFail($request->integer('address_id'));
        /** @var Address $address */

        $order = $checkoutService->placeOrder($request->user(), $address, $request->validated());

        return Redirect::route('customer.orders.show', $order)->with('status', 'Order placed successfully.');
    }
}
