<?php

namespace App\Http\Controllers\Admin;

use App\Events\VendorApproved;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(): View
    {
        return view('admin.vendors.index', [
            'stores' => Store::query()->with('owner')->latest()->paginate(12),
        ]);
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $request->validate(['approval_status' => ['required', 'in:pending,approved,rejected']]);

        $store->update([
            'approval_status' => $request->string('approval_status')->toString(),
            'approved_at' => $request->string('approval_status')->toString() === 'approved' ? now() : null,
        ]);

        if ($store->approval_status === 'approved') {
            VendorApproved::dispatch($store);
        }

        return Redirect::route('admin.vendors.index')->with('status', 'Vendor status updated.');
    }
}
