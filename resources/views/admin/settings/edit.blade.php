@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
    <x-ui.page-header title="Platform Settings" description="Simple settings storage in the database for deployment-friendly configuration." />

    <x-ui.card>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-5 md:grid-cols-2">
            @csrf
            @method('PATCH')
            <x-ui.input name="store_name" label="Store name" :value="$flatSettings['store_name']" />
            <x-ui.input name="support_email" label="Support email" :value="$flatSettings['support_email']" />
            <x-ui.input name="currency" label="Currency" :value="$flatSettings['currency']" />
            <x-ui.input name="homepage_hero" label="Homepage hero" :value="$flatSettings['homepage_hero']" />
            <div class="md:col-span-2">
                <x-ui.button type="submit">Save settings</x-ui.button>
            </div>
        </form>
    </x-ui.card>
@endsection
