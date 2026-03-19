<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreAddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.addresses.index', [
            'addresses' => $request->user()->addresses()->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('customer.addresses.create');
    }

    public function store(StoreAddressRequest $request): RedirectResponse
    {
        if ($request->boolean('is_default')) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $request->user()->addresses()->create($request->validated());

        return Redirect::route('customer.addresses.index')->with('status', 'Address added.');
    }

    public function edit(Address $address): View
    {
        $this->authorize('update', $address);

        return view('customer.addresses.edit', ['address' => $address]);
    }

    public function update(StoreAddressRequest $request, Address $address): RedirectResponse
    {
        $this->authorize('update', $address);

        if ($request->boolean('is_default')) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address->update($request->validated());

        return Redirect::route('customer.addresses.index')->with('status', 'Address updated.');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $this->authorize('delete', $address);
        $address->delete();

        return Redirect::route('customer.addresses.index')->with('status', 'Address removed.');
    }
}
