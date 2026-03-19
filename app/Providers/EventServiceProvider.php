<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\VendorApproved;
use App\Listeners\SendOrderPlacedNotifications;
use App\Listeners\SendVendorApprovedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(OrderPlaced::class, SendOrderPlacedNotifications::class);
        Event::listen(VendorApproved::class, SendVendorApprovedNotification::class);
    }
}
