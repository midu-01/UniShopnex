@extends('layouts.dashboard')

@section('title', 'Store Profile')

@section('content')
    <x-ui.page-header title="Store Profile" description="Vendors can configure their public storefront details here." />

    <x-ui.card>
        <form method="POST" action="{{ route('vendor.store.update') }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
            @csrf
            @method('PATCH')
            <x-ui.input name="name" label="Store name" :value="$store->name" />
            <x-ui.input name="email" label="Store email" :value="$store->email" />
            <x-ui.input name="phone" label="Phone" :value="$store->phone" />
            <x-ui.input name="country" label="Country" :value="$store->country" />
            <div class="md:col-span-2">
                <x-ui.textarea name="description" label="Description" :value="$store->description" />
            </div>
            <x-ui.input name="address_line" label="Address line" :value="$store->address_line" />
            <x-ui.input name="city" label="City" :value="$store->city" />
            <x-ui.input name="state" label="State" :value="$store->state" />
            <x-ui.input name="postal_code" label="Postal code" :value="$store->postal_code" />
            <label class="block">
                <span class="label">Logo</span>
                <input class="input" type="file" name="logo">
            </label>
            <label class="block">
                <span class="label">Banner</span>
                <input class="input" type="file" name="banner">
            </label>
            <div class="md:col-span-2">
                <x-ui.button type="submit">Save store profile</x-ui.button>
            </div>
        </form>
    </x-ui.card>
@endsection
