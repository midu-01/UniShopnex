<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sales:send-daily-summaries')->dailyAt('22:00');
Schedule::command('carts:cleanup-abandoned')->dailyAt('01:00');
Schedule::command('inventory:check-low-stock')->hourly();
