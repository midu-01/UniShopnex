@props(['variant' => 'default'])

@php
    $classes = match ($variant) {
        'success' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300',
        'warning' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300',
        'danger' => 'bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300',
        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex rounded-full px-3 py-1 text-xs font-semibold '.$classes]) }}>
    {{ $slot }}
</span>
