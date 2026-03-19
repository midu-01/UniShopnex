<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'UniShopnex') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
        @include('layouts.partials.theme-script')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="shell">
        <div class="mx-auto flex min-h-screen max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="hidden rounded-[2rem] border border-white/20 bg-indigo-600/90 p-10 text-white shadow-2xl backdrop-blur lg:flex lg:flex-col lg:justify-between">
                    <div>
                        <x-application-logo class="text-white" />
                        <h1 class="mt-10 text-4xl font-semibold">Learn the Laravel roadmap through one serious SaaS build.</h1>
                        <p class="mt-4 text-indigo-100">Multi-vendor commerce, API auth, queues, policies, events, dashboards, and a UI system that feels production-ready.</p>
                    </div>
                    <p class="text-sm text-indigo-100">Admin: `admin@unishopnex.test` / `password`</p>
                </div>
                <div class="panel mx-auto w-full max-w-xl p-8 sm:p-10">
                    <div class="mb-8 flex items-center justify-between">
                        <a href="{{ route('home') }}">
                            <x-application-logo />
                        </a>
                        <button type="button" onclick="window.applyTheme(localStorage.getItem('theme') === 'dark' ? 'light' : 'dark')" class="btn-secondary">
                            Theme
                        </button>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
