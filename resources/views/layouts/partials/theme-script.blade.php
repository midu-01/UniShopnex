<script>
    window.applyTheme = function (theme) {
        const resolved = theme === 'system'
            ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
            : theme;

        document.documentElement.classList.toggle('dark', resolved === 'dark');
        localStorage.setItem('theme', theme);
    };

    window.applyTheme(localStorage.getItem('theme') ?? 'system');
</script>
