@extends('layouts.dashboard')

@section('title', $order->order_number)

@section('content')
    <x-ui.page-header :title="$order->order_number" description="Vendor view into order items relevant to the store." />

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
        <x-ui.card>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    @if ($item->store_id === auth()->user()->store?->id)
                        <div class="panel-muted flex items-center justify-between px-4 py-3">
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Qty {{ $item->quantity }}</p>
                            </div>
                            <p class="font-medium text-slate-900 dark:text-white">${{ number_format($item->total_price, 2) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </x-ui.card>
        <x-ui.card>
            <p class="text-sm text-slate-500 dark:text-slate-400">Customer</p>
            <p class="mt-2 font-semibold text-slate-900 dark:text-white">{{ $order->user->name }}</p>
            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Payment: {{ ucfirst($order->payment_status) }}</p>
        </x-ui.card>
    </div>
@endsection
