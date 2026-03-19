<?php

namespace App\Console\Commands;

use App\Jobs\SendDailySalesSummaryJob;
use App\Models\User;
use App\Services\VendorAnalyticsService;
use Illuminate\Console\Command;

class SendDailySalesSummariesCommand extends Command
{
    protected $signature = 'sales:send-daily-summaries';

    protected $description = 'Send daily sales summaries to vendors';

    public function __construct(
        protected VendorAnalyticsService $analytics,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        User::role('vendor')->get()->each(function (User $vendor): void {
            SendDailySalesSummaryJob::dispatch($vendor, $this->analytics->summary($vendor));
        });

        $this->info('Daily sales summaries queued.');

        return self::SUCCESS;
    }
}
