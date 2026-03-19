<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\CatalogService;

class ProductObserver
{
    public function created(Product $product): void
    {
        app(CatalogService::class)->flushCache($product);
    }

    public function updated(Product $product): void
    {
        app(CatalogService::class)->flushCache($product);
    }

    public function deleted(Product $product): void
    {
        app(CatalogService::class)->flushCache($product);
    }
}
