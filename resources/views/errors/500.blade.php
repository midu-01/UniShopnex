@extends('layouts.storefront')

@section('title', 'Server Error')

@section('content')
    <x-ui.empty-state title="Something went wrong" description="The application hit an unexpected issue. Check logs, queues, and exception handling while learning through the project.">
        <x-ui.button :href="route('home')" variant="secondary">Back to safety</x-ui.button>
    </x-ui.empty-state>
@endsection
