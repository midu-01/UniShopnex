@extends('layouts.dashboard')

@section('title', 'Checkout')

@section('content')
    <x-ui.page-header title="Checkout" description="Form request validation, order service orchestration, and event dispatching happen here." />

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
        <x-ui.card>
            <form method="POST" action="{{ route('customer.checkout.store') }}" class="space-y-5">
                @csrf
                <x-ui.select name="address_id" label="Shipping address">
                    @foreach ($addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->label ?? $address->full_name }} - {{ $address->city }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select name="provider" label="Payment provider">
                    <option value="manual">Manual demo payment</option>
                    <option value="cash_on_delivery">Cash on delivery</option>
                </x-ui.select>
                <x-ui.textarea name="notes" label="Order notes" rows="4" />
                <x-ui.button type="submit">Place order</x-ui.button>
            </form>
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Order total</h2>
            <dl class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                <div class="flex justify-between"><dt>Subtotal</dt><dd>${{ number_format($totals['subtotal'], 2) }}</dd></div>
                <div class="flex justify-between"><dt>Tax</dt><dd>${{ number_format($totals['tax'], 2) }}</dd></div>
                <div class="flex justify-between"><dt>Shipping</dt><dd>${{ number_format($totals['shipping'], 2) }}</dd></div>
                <div class="flex justify-between font-semibold text-slate-900 dark:text-white"><dt>Total</dt><dd>${{ number_format($totals['total'], 2) }}</dd></div>
            </dl>
        </x-ui.card>
    </div>
@endsection
