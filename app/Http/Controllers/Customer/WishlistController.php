<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.wishlist.index', [
            'products' => $request->user()->wishlistProducts()->with(['store', 'primaryImage'])->paginate(12),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['product_id' => ['required', 'exists:products,id']]);
        $request->user()->wishlistProducts()->syncWithoutDetaching([$request->integer('product_id')]);

        return Redirect::back()->with('status', 'Added to wishlist.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $request->user()->wishlistProducts()->detach($product->id);

        return Redirect::back()->with('status', 'Removed from wishlist.');
    }
}
