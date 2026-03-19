@extends('layouts.dashboard')

@section('title', 'Wishlist')

@section('content')
    <x-ui.page-header title="Wishlist" description="Optional many-to-many behavior through a dedicated pivot model." />

    @if ($products->count())
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($products as $product)
                <x-ui.card>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $product->store->name }}</p>
                    <div class="mt-5 flex items-center justify-between">
                        <x-ui.badge variant="success">${{ number_format($product->price, 2) }}</x-ui.badge>
                        <form method="POST" action="{{ route('customer.wishlist.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Remove</x-ui.button>
                        </form>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <x-ui.empty-state title="Wishlist is empty" description="Save products for later from the storefront." />
    @endif
@endsection
