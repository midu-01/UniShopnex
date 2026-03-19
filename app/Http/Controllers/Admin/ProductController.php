<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()
                ->with(['store.owner', 'category', 'primaryImage'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::route('admin.products.index')->with('status', 'Product deleted.');
    }
}
