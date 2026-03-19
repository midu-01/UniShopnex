<?php

namespace App\Console\Commands;

use App\Jobs\CheckLowStockJob;
use Illuminate\Console\Command;

class CheckLowStockCommand extends Command
{
    protected $signature = 'inventory:check-low-stock';

    protected $description = 'Queue low stock notifications for vendors';

    public function handle(): int
    {
        CheckLowStockJob::dispatch();

        $this->info('Low stock check queued.');

        return self::SUCCESS;
    }
}
