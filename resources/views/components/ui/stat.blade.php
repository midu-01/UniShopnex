@props(['label', 'value', 'hint' => null])

<div class="metric-card">
    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <p class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white">{{ $value }}</p>
    @if ($hint)
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $hint }}</p>
    @endif
</div>
