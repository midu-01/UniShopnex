<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UpdateStoreProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function edit(Request $request): View
    {
        $store = $request->user()->store()->firstOrCreate([
            'user_id' => $request->user()->id,
        ], [
            'name' => $request->user()->name."'s Store",
            'slug' => Str::slug($request->user()->name.'-'.Str::random(5)),
        ]);

        return view('vendor.store.edit', ['store' => $store]);
    }

    public function update(UpdateStoreProfileRequest $request): RedirectResponse
    {
        $store = $request->user()->store;
        $this->authorize('update', $store);

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner_path'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $data['slug'] = $store->slug ?: Str::slug($request->string('name').'-'.Str::random(5));

        $store->update($data);

        return Redirect::route('vendor.store.edit')->with('status', 'Store updated successfully.');
    }
}
