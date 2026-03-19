<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginateForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Order::query()
            ->with(['items.product.primaryImage', 'payment'])
            ->whereBelongsTo($user)
            ->latest('placed_at')
            ->paginate($perPage);
    }

    public function paginateForVendor(User $vendor, int $perPage = 10): LengthAwarePaginator
    {
        return Order::query()
            ->with(['user', 'items.product.primaryImage'])
            ->whereHas('items', fn ($query) => $query->where('store_id', $vendor->store?->id))
            ->latest('placed_at')
            ->paginate($perPage);
    }
}
