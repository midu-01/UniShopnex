@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard')

@section('content')
    <x-ui.page-header title="Vendor Dashboard" description="Store analytics, order counts, and sales snapshots for the current vendor." />

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <x-ui.stat label="Products" :value="$summary['products_count']" />
        <x-ui.stat label="Orders" :value="$summary['orders_count']" />
        <x-ui.stat label="Units sold" :value="$summary['units_sold']" />
        <x-ui.stat label="Revenue" :value="'$'.number_format($summary['revenue'], 2)" />
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Store status</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">{{ $store?->name ?? 'Store not configured yet' }}</p>
            @if ($store)
                <div class="mt-3">
                    <x-ui.badge :variant="$store->approval_status === 'approved' ? 'success' : 'warning'">{{ ucfirst($store->approval_status) }}</x-ui.badge>
                </div>
            @endif
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Recent sales</h2>
            <div class="mt-4 space-y-3">
                @forelse ($summary['recent_sales'] as $sale)
                    <div class="panel-muted flex items-center justify-between px-4 py-3">
                        <span class="text-sm text-slate-600 dark:text-slate-300">Order #{{ $sale->order_id }}</span>
                        <span class="font-medium text-slate-900 dark:text-white">${{ number_format($sale->total_price, 2) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 dark:text-slate-400">No recent sales yet.</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>
@endsection
