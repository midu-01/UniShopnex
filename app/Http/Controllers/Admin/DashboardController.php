<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\AdminDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(AdminDashboardService $dashboard): View
    {
        return view('admin.dashboard', [
            'metrics' => $dashboard->metrics(),
            'activities' => ActivityLog::query()->with('user')->latest()->limit(10)->get(),
        ]);
    }
}
