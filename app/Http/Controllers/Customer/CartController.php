<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request, CartService $cartService): View
    {
        $cart = $cartService->current($request->user());

        return view('customer.cart', [
            'cart' => $cart,
            'totals' => $cartService->totals($cart),
        ]);
    }

    public function store(Request $request, CartService $cartService): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::query()->findOrFail($request->integer('product_id'));
        $cartService->add($request->user(), $product, $request->integer('quantity', 1));

        return Redirect::route('customer.cart.index')->with('status', 'Product added to cart.');
    }

    public function update(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:0']]);

        $cartService->updateQuantity($request->user(), $product, $request->integer('quantity'));

        return Redirect::route('customer.cart.index')->with('status', 'Cart updated.');
    }

    public function destroy(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $cartService->updateQuantity($request->user(), $product, 0);

        return Redirect::route('customer.cart.index')->with('status', 'Item removed from cart.');
    }
}
