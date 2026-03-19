@extends('layouts.storefront')

@section('title', 'UniShopnex')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="panel p-8 sm:p-10">
            <x-ui.badge variant="success">Laravel roadmap project</x-ui.badge>
            <h1 class="mt-6 text-4xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                Multi-vendor SaaS commerce built to teach Laravel end to end.
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600 dark:text-slate-300">
                Explore stores, browse products, manage carts and orders, and inspect real code for policies, services, queues, notifications, APIs, and dashboards.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <x-ui.button :href="route('products.index')">Browse products</x-ui.button>
                @auth
                    <x-ui.button :href="route('dashboard')" variant="secondary">Open dashboard</x-ui.button>
                @else
                    <x-ui.button :href="route('register')" variant="secondary">Create account</x-ui.button>
                @endauth
            </div>
        </div>
        <div class="grid gap-6">
            <x-ui.stat label="Featured products" :value="$featuredProducts->count()" hint="Cached catalog sections demonstrate performance patterns." />
            <x-ui.stat label="Featured categories" :value="$featuredCategories->count()" hint="Reusable Blade components drive the storefront UI." />
            <x-ui.stat label="Demo stores" :value="$stores->count()" hint="Vendor stores and admin workflows are seeded for learning." />
        </div>
    </section>

    <section class="mt-12">
        <x-ui.page-header title="Featured Categories" description="Use these categories to explore filtering, relationships, and catalog queries." />
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($featuredCategories as $category)
                <x-ui.card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $category->name }}</h3>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $category->description }}</p>
                        </div>
                        <x-ui.badge>{{ $category->products_count }} products</x-ui.badge>
                    </div>
                    <div class="mt-6">
                        <x-ui.button :href="route('products.index', ['category' => $category->slug])" variant="secondary">Explore category</x-ui.button>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </section>

    <section class="mt-12">
        <x-ui.page-header title="Featured Products" description="Search, filtering, eager loading, and API resources all use the same product model layer." />
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($featuredProducts as $product)
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
    </section>
@endsection
