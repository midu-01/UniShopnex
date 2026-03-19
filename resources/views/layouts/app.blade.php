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
        <div class="min-h-screen px-4 py-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                @include('layouts.navigation')

                @isset($header)
                    <div class="mt-6 panel px-6 py-5">
                        {{ $header }}
                    </div>
                @endisset

                <main class="mt-6">
                    @include('layouts.partials.flash')
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
