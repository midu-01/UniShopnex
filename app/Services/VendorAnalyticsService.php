<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Collection;

class VendorAnalyticsService
{
    public function summary(User $vendor): array
    {
        $storeId = $vendor->store?->id;

        $items = OrderItem::query()
            ->with('order')
            ->when($storeId, fn ($query) => $query->where('store_id', $storeId))
            ->get();

        return [
            'products_count' => $vendor->store?->products()->count() ?? 0,
            'orders_count' => $items->pluck('order_id')->unique()->count(),
            'units_sold' => $items->sum('quantity'),
            'revenue' => $items->sum('total_price'),
            'recent_sales' => $items->sortByDesc('created_at')->take(5)->values(),
        ];
    }

    public function chart(User $vendor): Collection
    {
        return OrderItem::query()
            ->selectRaw('DATE(created_at) as day, SUM(total_price) as total')
            ->where('store_id', $vendor->store?->id)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }
}
