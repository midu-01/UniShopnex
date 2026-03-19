<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    public function index(Request $request, CatalogService $catalog): View
    {
        $filters = $request->only(['search', 'category', 'store']);

        return view('storefront.products.index', [
            'filters' => $filters,
            'categories' => $catalog->navigationCategories(),
            'products' => $catalog->listProducts($filters),
        ]);
    }
}
