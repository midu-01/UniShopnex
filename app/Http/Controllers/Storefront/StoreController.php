<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function show(Store $store): View
    {
        abort_unless($store->approval_status === 'approved' && $store->is_active, 404);

        return view('storefront.stores.show', [
            'store' => $store->load(['owner', 'products.primaryImage', 'products.category']),
        ]);
    }
}
