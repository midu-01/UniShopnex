<?php

namespace App\Listeners;

use App\Events\VendorApproved;
use App\Notifications\VendorApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVendorApprovedNotification implements ShouldQueue
{
    public function handle(VendorApproved $event): void
    {
        $event->store->owner?->notify(new VendorApprovedNotification($event->store));
    }
}
