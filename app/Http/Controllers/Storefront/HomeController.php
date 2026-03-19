<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\CatalogService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return $this->index(app(CatalogService::class));
    }

    public function index(CatalogService $catalog): View
    {
        return view('storefront.home', [
            'featuredProducts' => $catalog->featuredProducts(),
            'featuredCategories' => $catalog->featuredCategories(),
            'stores' => Store::query()
                ->where('approval_status', 'approved')
                ->where('is_active', true)
                ->withCount('products')
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
