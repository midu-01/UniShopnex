@extends('layouts.dashboard')

@section('title', 'Vendor Products')

@section('content')
    <x-ui.page-header title="Products" description="Vendor-owned CRUD powered by policies, form requests, and file uploads.">
        <x-ui.button :href="route('vendor.products.create')">Add product</x-ui.button>
    </x-ui.page-header>

    @if ($products->count())
        <div class="space-y-4">
            @foreach ($products as $product)
                <x-ui.card>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $product->name }}</p>
                                <x-ui.badge>{{ ucfirst($product->status) }}</x-ui.badge>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">${{ number_format($product->price, 2) }} • {{ $product->stock_quantity }} in stock</p>
                        </div>
                        <div class="flex gap-2">
                            <x-ui.button :href="route('vendor.products.edit', $product)" variant="secondary">Edit</x-ui.button>
                            <form method="POST" action="{{ route('vendor.products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                            </form>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <x-ui.empty-state title="No products yet" description="Create the first product for your store.">
            <x-ui.button :href="route('vendor.products.create')">Create product</x-ui.button>
        </x-ui.empty-state>
    @endif
@endsection
