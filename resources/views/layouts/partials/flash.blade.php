@if (session('status'))
    <div class="panel mb-6 border-emerald-200 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-200">
        {{ session('status') }}
    </div>
@endif
