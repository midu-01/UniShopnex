@extends('layouts.storefront')

@section('title', 'Products')

@section('content')
    <x-ui.page-header title="Product Catalog" description="Search, filter, paginate, and inspect how the repository/service layer powers the storefront.">
        <x-ui.button :href="route('home')" variant="secondary">Back home</x-ui.button>
    </x-ui.page-header>

    <div class="grid gap-8 lg:grid-cols-[260px_minmax(0,1fr)]">
        <x-ui.card class="h-fit">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <x-ui.input name="search" label="Search" :value="$filters['search'] ?? null" placeholder="Search products..." />
                <x-ui.select name="category" label="Category">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.button type="submit">Apply filters</x-ui.button>
            </form>
        </x-ui.card>

        <div class="space-y-6">
            @if ($products->count())
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $product)
                        <x-ui.card class="flex h-full flex-col">
                            <div class="aspect-[4/3] rounded-2xl bg-slate-100 dark:bg-slate-800"></div>
                            <div class="mt-5 flex flex-1 flex-col">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $product->name }}</h3>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $product->store->name }}</p>
                                    </div>
                                    <x-ui.badge variant="success">${{ number_format($product->price, 2) }}</x-ui.badge>
                                </div>
                                <p class="mt-3 flex-1 text-sm text-slate-500 dark:text-slate-400">{{ $product->short_description }}</p>
                                <div class="mt-5">
                                    <x-ui.button :href="route('products.show', $product->slug)" variant="secondary">View details</x-ui.button>
                                </div>
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <x-ui.empty-state title="No products found" description="Try adjusting the search term or filter selection.">
                    <x-ui.button :href="route('products.index')" variant="secondary">Reset filters</x-ui.button>
                </x-ui.empty-state>
            @endif
        </div>
    </div>
@endsection
