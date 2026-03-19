@extends('layouts.dashboard')

@section('title', 'Cart')

@section('content')
    <x-ui.page-header title="Shopping Cart" description="Session-backed cart flow with service-layer totals and update actions.">
        <x-ui.button :href="route('products.index')" variant="secondary">Continue shopping</x-ui.button>
    </x-ui.page-header>

    @if ($cart->items->count())
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <div class="space-y-4">
                @foreach ($cart->items as $item)
                    <x-ui.card>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $item->product->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $item->product->store->name }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <form method="POST" action="{{ route('customer.cart.update', $item->product) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input class="input w-24" type="number" min="0" name="quantity" value="{{ $item->quantity }}">
                                    <x-ui.button type="submit" variant="secondary">Update</x-ui.button>
                                </form>
                                <form method="POST" action="{{ route('customer.cart.destroy', $item->product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" variant="danger">Remove</x-ui.button>
                                </form>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
            <x-ui.card>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Summary</h2>
                <dl class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <div class="flex justify-between"><dt>Subtotal</dt><dd>${{ number_format($totals['subtotal'], 2) }}</dd></div>
                    <div class="flex justify-between"><dt>Tax</dt><dd>${{ number_format($totals['tax'], 2) }}</dd></div>
                    <div class="flex justify-between"><dt>Shipping</dt><dd>${{ number_format($totals['shipping'], 2) }}</dd></div>
                    <div class="flex justify-between font-semibold text-slate-900 dark:text-white"><dt>Total</dt><dd>${{ number_format($totals['total'], 2) }}</dd></div>
                </dl>
                <div class="mt-6">
                    <x-ui.button :href="route('customer.checkout.create')">Proceed to checkout</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    @else
        <x-ui.empty-state title="Your cart is empty" description="Add a few products from the storefront to test the full checkout pipeline.">
            <x-ui.button :href="route('products.index')">Browse products</x-ui.button>
        </x-ui.empty-state>
    @endif
@endsection
