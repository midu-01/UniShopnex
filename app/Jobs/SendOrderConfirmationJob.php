<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOrderConfirmationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
    ) {
    }

    public function handle(): void
    {
        $order = $this->order->loadMissing(['user', 'items.store.owner']);

        $order->user?->notify(new OrderPlacedNotification($order, 'customer'));

        $vendors = $order->items
            ->map(fn ($item) => $item->store?->owner)
            ->filter()
            ->unique(fn (User $user) => $user->id);

        foreach ($vendors as $vendor) {
            $vendor->notify(new OrderPlacedNotification($order, 'vendor'));
        }

        User::role('admin')->get()->each(
            fn (User $admin) => $admin->notify(new OrderPlacedNotification($order, 'admin'))
        );
    }
}
