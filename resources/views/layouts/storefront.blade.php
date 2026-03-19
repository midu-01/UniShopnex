@extends('layouts.base')

@section('page')
    @php($categories = app(\App\Services\CatalogService::class)->navigationCategories())

    <div class="min-h-screen">
        <header class="sticky top-0 z-40 border-b border-white/20 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-950/80">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <x-application-logo />
                </a>
                <nav class="hidden items-center gap-6 lg:flex">
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Browse products</a>
                    @foreach ($categories->take(4) as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.applyTheme(localStorage.getItem('theme') === 'dark' ? 'light' : 'dark')" class="btn-secondary">
                        Theme
                    </button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary">Get started</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @include('layouts.partials.flash')
            @yield('content')
        </main>
    </div>
@endsection
