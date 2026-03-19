<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $productSlug, CatalogService $catalog): View
    {
        $product = $catalog->findProductBySlug($productSlug);

        abort_if(! $product, 404);

        return view('storefront.products.show', [
            'product' => $product,
            'relatedProducts' => $catalog->listProducts([
                'category' => $product->category?->slug,
            ], 4),
        ]);
    }
}
