<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class AdminDashboardService
{
    public function metrics(): array
    {
        return [
            'users_count' => User::count(),
            'vendors_count' => User::role('vendor')->count(),
            'customers_count' => User::role('customer')->count(),
            'stores_count' => Store::count(),
            'pending_stores_count' => Store::where('approval_status', 'pending')->count(),
            'products_count' => Product::count(),
            'published_products_count' => Product::published()->count(),
            'orders_count' => Order::count(),
            'revenue' => Order::sum('total_amount'),
            'recent_orders' => Order::with(['user', 'items'])->latest('placed_at')->limit(5)->get(),
        ];
    }
}
