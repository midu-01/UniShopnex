@extends('layouts.base')

@php
    $role = auth()->user()?->isAdmin() ? 'admin' : (auth()->user()?->isVendor() ? 'vendor' : 'customer');
    $navigation = [
        'customer' => [
            ['label' => 'Dashboard', 'route' => 'customer.dashboard'],
            ['label' => 'Addresses', 'route' => 'customer.addresses.index'],
            ['label' => 'Cart', 'route' => 'customer.cart.index'],
            ['label' => 'Orders', 'route' => 'customer.orders.index'],
            ['label' => 'Wishlist', 'route' => 'customer.wishlist.index'],
        ],
        'vendor' => [
            ['label' => 'Dashboard', 'route' => 'vendor.dashboard'],
            ['label' => 'Store profile', 'route' => 'vendor.store.edit'],
            ['label' => 'Products', 'route' => 'vendor.products.index'],
            ['label' => 'Orders', 'route' => 'vendor.orders.index'],
        ],
        'admin' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Users', 'route' => 'admin.users.index'],
            ['label' => 'Vendors', 'route' => 'admin.vendors.index'],
            ['label' => 'Categories', 'route' => 'admin.categories.index'],
            ['label' => 'Products', 'route' => 'admin.products.index'],
            ['label' => 'Orders', 'route' => 'admin.orders.index'],
            ['label' => 'Settings', 'route' => 'admin.settings.edit'],
        ],
    ][$role];
@endphp

@section('page')
    <div class="min-h-screen px-4 py-4 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="panel hidden p-6 lg:block">
                <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3">
                    <x-application-logo />
                </a>

                <div class="space-y-2">
                    @foreach ($navigation as $item)
                        <a href="{{ route($item['route']) }}" class="@class([
                            'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                            'bg-indigo-600 text-white' => request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => ! (request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route']))),
                        ])">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </aside>

            <div class="space-y-6">
                <header class="panel flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ ucfirst($role) }} workspace</p>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="btn-secondary">Storefront</a>
                        <button type="button" onclick="window.applyTheme(localStorage.getItem('theme') === 'dark' ? 'light' : 'dark')" class="btn-secondary">
                            Theme
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.button type="submit" variant="danger">Logout</x-ui.button>
                        </form>
                    </div>
                </header>

                @include('layouts.partials.flash')

                @yield('content')
            </div>
        </div>
    </div>
@endsection
