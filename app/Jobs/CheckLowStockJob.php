<?php

namespace App\Jobs;

use App\Models\Product;
use App\Notifications\LowStockAlertNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckLowStockJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        Product::query()
            ->with('store.owner')
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->where('status', 'published')
            ->get()
            ->each(function (Product $product): void {
                $product->store?->owner?->notify(new LowStockAlertNotification($product));
            });
    }
}
