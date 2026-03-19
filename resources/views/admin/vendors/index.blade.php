@extends('layouts.dashboard')

@section('title', 'Vendors')

@section('content')
    <x-ui.page-header title="Vendor Approvals" description="Approve or reject stores with an event-driven notification workflow." />

    <div class="space-y-4">
        @foreach ($stores as $store)
            <x-ui.card>
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $store->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $store->owner->name }} • {{ $store->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.vendors.update', $store) }}" class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <select class="input w-44" name="approval_status">
                            @foreach (['pending', 'approved', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected($store->approval_status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <x-ui.button type="submit">Save</x-ui.button>
                    </form>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <div class="mt-6">{{ $stores->links() }}</div>
@endsection
