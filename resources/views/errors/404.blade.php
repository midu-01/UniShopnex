@extends('layouts.storefront')

@section('title', 'Page Not Found')

@section('content')
    <x-ui.empty-state title="Page not found" description="The page you requested does not exist or may have moved.">
        <x-ui.button :href="route('home')">Return home</x-ui.button>
    </x-ui.empty-state>
@endsection
