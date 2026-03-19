@extends('layouts.dashboard')

@section('title', 'Products')

@section('content')
    <x-ui.page-header title="All Products" description="Platform-wide product moderation and catalog oversight." />

    <div class="space-y-4">
        @foreach ($products as $product)
            <x-ui.card>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $product->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $product->store->name }} • {{ $product->category?->name }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                    </form>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection
