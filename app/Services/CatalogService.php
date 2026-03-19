<?php

namespace App\Services;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CatalogService
{
    public function __construct(
        protected ProductRepositoryInterface $products,
    ) {
    }

    public function featuredProducts(): Collection
    {
        return Cache::remember('storefront.featured-products', now()->addMinutes(15), fn () => $this->products->featured());
    }

    public function featuredCategories(): Collection
    {
        return Cache::remember('storefront.featured-categories', now()->addMinutes(30), function (): Collection {
            return Category::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->withCount('products')
                ->orderBy('sort_order')
                ->limit(6)
                ->get();
        });
    }

    public function listProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        return $this->products->paginatePublished($filters, $perPage);
    }

    public function findProductBySlug(string $slug): ?Product
    {
        return Cache::remember(
            'storefront.product.'.$slug,
            now()->addMinutes(15),
            fn () => $this->products->findPublishedBySlug($slug)
        );
    }

    public function navigationCategories(): Collection
    {
        return Cache::remember('storefront.navigation-categories', now()->addMinutes(60), function (): Collection {
            return Category::query()
                ->where('is_active', true)
                ->withCount('products')
                ->orderBy('sort_order')
                ->get();
        });
    }

    public function flushCache(?Product $product = null): void
    {
        Cache::forget('storefront.featured-products');
        Cache::forget('storefront.featured-categories');
        Cache::forget('storefront.navigation-categories');

        if ($product) {
            Cache::forget('storefront.product.'.$product->slug);
        }
    }
}
