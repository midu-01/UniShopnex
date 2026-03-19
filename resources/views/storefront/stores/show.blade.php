@extends('layouts.storefront')

@section('title', $store->name)

@section('content')
    <x-ui.card>
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <x-ui.badge variant="success">{{ ucfirst($store->approval_status) }}</x-ui.badge>
                <h1 class="mt-4 text-3xl font-semibold text-slate-900 dark:text-white">{{ $store->name }}</h1>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">{{ $store->description }}</p>
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">{{ $store->full_address }}</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-ui.stat label="Products" :value="$store->products->count()" />
                <x-ui.stat label="Owner" :value="$store->owner->name" />
            </div>
        </div>
    </x-ui.card>

    <section class="mt-12">
        <x-ui.page-header title="Store Products" description="Vendor-owned catalog powered by store and product relationships." />
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($store->products as $product)
                <x-ui.card>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $product->short_description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <x-ui.badge variant="success">${{ number_format($product->price, 2) }}</x-ui.badge>
                        <x-ui.button :href="route('products.show', $product->slug)" variant="secondary">View</x-ui.button>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </section>
@endsection
