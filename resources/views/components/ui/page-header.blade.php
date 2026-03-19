@props(['title', 'description' => null])

<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
        @endif
    </div>
    @if (trim($slot))
        <div class="flex items-center gap-3">
            {{ $slot }}
        </div>
    @endif
</div>
