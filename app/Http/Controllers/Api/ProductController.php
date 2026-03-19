<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request, CatalogService $catalog): AnonymousResourceCollection
    {
        return ProductResource::collection($catalog->listProducts($request->only(['search', 'category', 'store'])));
    }

    public function show(string $productSlug, CatalogService $catalog): ProductResource
    {
        $product = $catalog->findProductBySlug($productSlug);
        abort_if(! $product, 404);

        return new ProductResource($product);
    }
}
