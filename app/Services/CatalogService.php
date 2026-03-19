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
        return $this->rememberCollection(
            'storefront.featured-products',
            now()->addMinutes(15),
            fn (): Collection => $this->products->featured(),
        );
    }

    public function featuredCategories(): Collection
    {
        return $this->rememberCollection('storefront.featured-categories', now()->addMinutes(30), function (): Collection {
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
        $key = 'storefront.product.'.$slug;
        $cached = Cache::get($key);

        if ($cached === null || $cached instanceof Product) {
            return $cached ?? tap($this->products->findPublishedBySlug($slug), fn (?Product $product) => Cache::put($key, $product, now()->addMinutes(15)));
        }

        Cache::forget($key);

        return tap($this->products->findPublishedBySlug($slug), fn (?Product $product) => Cache::put($key, $product, now()->addMinutes(15)));
    }

    public function navigationCategories(): Collection
    {
        return $this->rememberCollection('storefront.navigation-categories', now()->addMinutes(60), function (): Collection {
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

    protected function rememberCollection(string $key, \DateTimeInterface|\DateInterval|int $ttl, callable $resolver): Collection
    {
        $cached = Cache::get($key);

        if ($cached instanceof Collection) {
            return $cached;
        }

        if ($cached !== null) {
            Cache::forget($key);
        }

        $fresh = $resolver();
        Cache::put($key, $fresh, $ttl);

        return $fresh;
    }
}
