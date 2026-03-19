<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\VendorAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, VendorAnalyticsService $analytics): View
    {
        return view('vendor.dashboard', [
            'summary' => $analytics->summary($request->user()),
            'chart' => $analytics->chart($request->user()),
            'store' => $request->user()->store,
        ]);
    }
}
