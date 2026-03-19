@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
    <x-ui.page-header title="Order History" description="Customer-facing order list backed by repository queries and eager loading." />

    @if ($orders->count())
        <div class="space-y-4">
            @foreach ($orders as $order)
                <x-ui.card>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $order->order_number }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ ucfirst($order->status) }} • ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <x-ui.button :href="route('customer.orders.show', $order)" variant="secondary">View order</x-ui.button>
                    </div>
                </x-ui.card>
            @endforeach
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    @else
        <x-ui.empty-state title="No orders yet" description="Place an order from the storefront to see it appear here." />
    @endif
@endsection
