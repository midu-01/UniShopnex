@extends('layouts.storefront')

@section('title', $product->name)

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_420px]">
        <x-ui.card class="p-0 overflow-hidden">
            <div class="aspect-[16/10] bg-slate-100 dark:bg-slate-800"></div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-3">
                <x-ui.badge>{{ $product->category?->name ?? 'Uncategorized' }}</x-ui.badge>
                @if ($product->is_featured)
                    <x-ui.badge variant="success">Featured</x-ui.badge>
                @endif
            </div>
            <h1 class="mt-5 text-3xl font-semibold text-slate-900 dark:text-white">{{ $product->name }}</h1>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">{{ $product->short_description }}</p>
            <div class="mt-6 flex items-center justify-between">
                <p class="text-3xl font-semibold text-slate-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('stores.show', $product->store->slug) }}" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">{{ $product->store->name }}</a>
            </div>

            <div class="mt-6 space-y-4">
                <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $product->description }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Stock: {{ $product->stock_quantity }} units</p>
            </div>

            @auth
                @if (auth()->user()->isCustomer())
                    <form method="POST" action="{{ route('customer.cart.store') }}" class="mt-8">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <x-ui.button type="submit">Add to cart</x-ui.button>
                    </form>
                @endif
            @else
                <div class="mt-8">
                    <x-ui.button :href="route('login')" variant="secondary">Login to purchase</x-ui.button>
                </div>
            @endauth
        </x-ui.card>
    </div>

    <section class="mt-12">
        <x-ui.page-header title="Related Products" description="More products from the same category." />
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($relatedProducts as $relatedProduct)
                @continue($relatedProduct->id === $product->id)
                <x-ui.card>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $relatedProduct->name }}</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $relatedProduct->short_description }}</p>
                    <div class="mt-4">
                        <x-ui.button :href="route('products.show', $relatedProduct->slug)" variant="secondary">View product</x-ui.button>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </section>
@endsection
