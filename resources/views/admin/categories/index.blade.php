@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')
    <x-ui.page-header title="Categories" description="Hierarchical categories for storefront filtering and vendor assignment.">
        <x-ui.button :href="route('admin.categories.create')">Add category</x-ui.button>
    </x-ui.page-header>

    <div class="space-y-4">
        @foreach ($categories as $category)
            <x-ui.card>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $category->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Parent: {{ $category->parent?->name ?? 'None' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button :href="route('admin.categories.edit', $category)" variant="secondary">Edit</x-ui.button>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
