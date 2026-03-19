<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginatePublished(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['store.owner', 'category', 'primaryImage'])
            ->published()
            ->when(
                filled($filters['search'] ?? null),
                fn (Builder $query) => $query->where(function (Builder $inner) use ($filters): void {
                    $inner
                        ->where('name', 'like', '%'.$filters['search'].'%')
                        ->orWhere('short_description', 'like', '%'.$filters['search'].'%')
                        ->orWhere('description', 'like', '%'.$filters['search'].'%');
                })
            )
            ->when(
                filled($filters['category'] ?? null),
                fn (Builder $query) => $query->whereHas(
                    'category',
                    fn (Builder $inner) => $inner->where('slug', $filters['category'])
                )
            )
            ->when(
                filled($filters['store'] ?? null),
                fn (Builder $query) => $query->whereHas(
                    'store',
                    fn (Builder $inner) => $inner->where('slug', $filters['store'])
                )
            )
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function featured(int $limit = 8): Collection
    {
        return Product::query()
            ->with(['store', 'category', 'primaryImage'])
            ->published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function findPublishedBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with(['store.owner', 'category', 'images', 'reviews.user'])
            ->published()
            ->where('slug', $slug)
            ->first();
    }

    public function paginateForVendor(User $vendor, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['category', 'primaryImage'])
            ->whereBelongsTo($vendor->store)
            ->latest()
            ->paginate($perPage);
    }
}
