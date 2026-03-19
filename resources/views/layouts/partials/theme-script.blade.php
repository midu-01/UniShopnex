<script>
    window.resolveTheme = function (theme) {
        return theme === 'system'
            ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
            : theme;
    };

    window.applyTheme = function (theme) {
        const storedTheme = theme ?? localStorage.getItem('theme') ?? 'system';
        const resolved = window.resolveTheme(storedTheme);

        document.documentElement.classList.toggle('dark', resolved === 'dark');
        document.documentElement.style.colorScheme = resolved;
        document.documentElement.dataset.theme = storedTheme;
        localStorage.setItem('theme', storedTheme);
    };

    window.toggleTheme = function () {
        const currentResolvedTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        window.applyTheme(currentResolvedTheme === 'dark' ? 'light' : 'dark');
    };

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
        if ((localStorage.getItem('theme') ?? 'system') === 'system') {
            window.applyTheme('system');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        window.applyTheme(localStorage.getItem('theme') ?? 'system');
    });

    if (document.readyState !== 'loading') {
        window.applyTheme(localStorage.getItem('theme') ?? 'system');
    } else {
        document.documentElement.classList.add('opacity-0');
        window.applyTheme(localStorage.getItem('theme') ?? 'system');
        document.documentElement.classList.remove('opacity-0');
    }
</script>
