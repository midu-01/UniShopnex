@extends('layouts.dashboard')

@section('title', 'Addresses')

@section('content')
    <x-ui.page-header title="Address Book" description="Customers can keep multiple shipping and billing addresses for checkout.">
        <x-ui.button :href="route('customer.addresses.create')">Add address</x-ui.button>
    </x-ui.page-header>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($addresses as $address)
            <x-ui.card>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $address->label ?? $address->full_name }}</h3>
                            @if ($address->is_default)
                                <x-ui.badge variant="success">Default</x-ui.badge>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $address->line_1 }}, {{ $address->city }}, {{ $address->country }}</p>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button :href="route('customer.addresses.edit', $address)" variant="secondary">Edit</x-ui.button>
                        <form method="POST" action="{{ route('customer.addresses.destroy', $address) }}">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.empty-state title="No addresses saved" description="Create an address to unlock the checkout flow." />
        @endforelse
    </div>
@endsection
