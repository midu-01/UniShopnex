@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <x-ui.page-header title="Users" description="Create admins, vendors, and customers directly from the platform.">
        <x-ui.button :href="route('admin.users.create')">Add user</x-ui.button>
    </x-ui.page-header>

    <div class="space-y-4">
        @foreach ($users as $user)
            <x-ui.card>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }} • {{ $user->roles->pluck('name')->join(', ') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button :href="route('admin.users.edit', $user)" variant="secondary">Edit</x-ui.button>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
