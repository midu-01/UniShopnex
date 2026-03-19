@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
    <x-ui.page-header title="Orders" description="Monitor and update all platform orders." />

    <div class="space-y-4">
        @foreach ($orders as $order)
            <x-ui.card>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $order->order_number }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $order->user->name }} • {{ ucfirst($order->status) }}</p>
                    </div>
                    <x-ui.button :href="route('admin.orders.show', $order)" variant="secondary">View</x-ui.button>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endsection
