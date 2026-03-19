<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function paginatePublished(array $filters = [], int $perPage = 12): LengthAwarePaginator;

    public function featured(int $limit = 8): Collection;

    public function findPublishedBySlug(string $slug): ?Product;

    public function paginateForVendor(User $vendor, int $perPage = 12): LengthAwarePaginator;
}
