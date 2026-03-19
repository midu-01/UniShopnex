@extends('layouts.dashboard')

@section('title', $order->order_number)

@section('content')
    <x-ui.page-header :title="$order->order_number" description="Update order and payment status from the admin workspace." />

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
        <x-ui.card>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="panel-muted flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->store->name }} • Qty {{ $item->quantity }}</p>
                        </div>
                        <p class="font-medium text-slate-900 dark:text-white">${{ number_format($item->total_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.card>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <x-ui.select name="status" label="Order status">
                    @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select name="payment_status" label="Payment status">
                    @foreach (['unpaid', 'paid', 'refunded'] as $status)
                        <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.button type="submit">Save status</x-ui.button>
            </form>
        </x-ui.card>
    </div>
@endsection
