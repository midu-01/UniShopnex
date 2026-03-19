<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;

class CleanupAbandonedCartsCommand extends Command
{
    protected $signature = 'carts:cleanup-abandoned';

    protected $description = 'Mark stale carts as abandoned and remove empty old carts';

    public function handle(): int
    {
        Cart::query()
            ->where('status', 'active')
            ->where('last_activity_at', '<=', now()->subDays(2))
            ->update(['status' => 'abandoned']);

        Cart::query()
            ->where('status', 'abandoned')
            ->whereDoesntHave('items')
            ->where('updated_at', '<=', now()->subDays(30))
            ->delete();

        $this->info('Abandoned carts cleaned.');

        return self::SUCCESS;
    }
}
