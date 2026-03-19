@extends('layouts.dashboard')

@section('title', $order->order_number)

@section('content')
    <x-ui.page-header :title="$order->order_number" description="Detailed order summary with items, status, and payment snapshot." />

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
        <x-ui.card>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="panel-muted flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Qty {{ $item->quantity }}</p>
                        </div>
                        <p class="font-medium text-slate-900 dark:text-white">${{ number_format($item->total_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.card>
            <dl class="space-y-3 text-sm text-slate-600 dark:text-slate-300">
                <div class="flex justify-between"><dt>Status</dt><dd>{{ ucfirst($order->status) }}</dd></div>
                <div class="flex justify-between"><dt>Payment</dt><dd>{{ ucfirst($order->payment_status) }}</dd></div>
                <div class="flex justify-between"><dt>Total</dt><dd>${{ number_format($order->total_amount, 2) }}</dd></div>
            </dl>
        </x-ui.card>
    </div>
@endsection
