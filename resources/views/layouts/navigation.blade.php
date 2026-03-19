<nav class="panel flex items-center justify-between px-6 py-4">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <x-application-logo />
    </a>

    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="btn-secondary">Storefront</a>
        <button type="button" onclick="window.toggleTheme()" class="btn-secondary">
            Theme
        </button>
        <div class="hidden text-right sm:block">
            <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-ui.button type="submit" variant="danger">Logout</x-ui.button>
        </form>
    </div>
</nav>
