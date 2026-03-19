<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Observers\ProductObserver;
use App\Policies\AddressPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\StorePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Store::class, StorePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Product::observe(ProductObserver::class);

        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'users' => User::class,
            'products' => Product::class,
            'stores' => Store::class,
            'orders' => Order::class,
            'categories' => Category::class,
            'addresses' => Address::class,
            'activity-logs' => ActivityLog::class,
        ]);
    }
}
