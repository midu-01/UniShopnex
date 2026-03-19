import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('themeSwitcher', () => ({
    theme: localStorage.getItem('theme') ?? 'system',
    toggle() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        window.applyTheme(this.theme);
    },
}));

Alpine.start();
