@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <x-ui.page-header title="Admin Dashboard" description="Platform-wide metrics, pending vendor reviews, and recent activity." />

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <x-ui.stat label="Users" :value="$metrics['users_count']" />
        <x-ui.stat label="Stores" :value="$metrics['stores_count']" />
        <x-ui.stat label="Products" :value="$metrics['products_count']" />
        <x-ui.stat label="Revenue" :value="'$'.number_format($metrics['revenue'], 2)" />
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Recent Orders</h2>
            <div class="mt-4 space-y-3">
                @foreach ($metrics['recent_orders'] as $order)
                    <div class="panel-muted flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $order->order_number }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $order->user->name }}</p>
                        </div>
                        <x-ui.button :href="route('admin.orders.show', $order)" variant="secondary">View</x-ui.button>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Recent Activity</h2>
            <div class="mt-4 space-y-3">
                @foreach ($activities as $activity)
                    <div class="panel-muted px-4 py-3">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $activity->description }}</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    </div>
@endsection
