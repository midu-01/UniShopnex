<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DailySalesSummaryNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendDailySalesSummaryJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $vendor,
        public array $summary,
    ) {
    }

    public function handle(): void
    {
        $this->vendor->notify(new DailySalesSummaryNotification($this->summary));
    }
}
