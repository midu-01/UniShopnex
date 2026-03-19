@extends('layouts.dashboard')

@section('title', 'Customer Dashboard')

@section('content')
    <x-ui.page-header title="Customer Dashboard" description="Track orders, saved addresses, and your active cart state." />

    <div class="grid gap-6 md:grid-cols-3">
        <x-ui.stat label="Orders" :value="$user->orders->count()" />
        <x-ui.stat label="Saved addresses" :value="$user->addresses->count()" />
        <x-ui.stat label="Cart total" :value="'$'.number_format($cartTotals['total'], 2)" />
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Recent Orders</h2>
            <div class="mt-4 space-y-3">
                @forelse ($recentOrders as $order)
                    <div class="panel-muted flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $order->order_number }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ ucfirst($order->status) }}</p>
                        </div>
                        <x-ui.button :href="route('customer.orders.show', $order)" variant="secondary">View</x-ui.button>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 dark:text-slate-400">No orders yet.</p>
                @endforelse
            </div>
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Quick Actions</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <x-ui.button :href="route('products.index')" variant="secondary">Browse products</x-ui.button>
                <x-ui.button :href="route('customer.cart.index')" variant="secondary">Open cart</x-ui.button>
                <x-ui.button :href="route('customer.addresses.index')" variant="secondary">Manage addresses</x-ui.button>
                <x-ui.button :href="route('customer.orders.index')" variant="secondary">Order history</x-ui.button>
            </div>
        </x-ui.card>
    </div>
@endsection
