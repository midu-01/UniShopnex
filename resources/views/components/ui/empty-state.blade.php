@props(['title', 'description'])

<div class="panel p-10 text-center">
    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    <div class="mt-6">
        {{ $slot }}
    </div>
</div>
