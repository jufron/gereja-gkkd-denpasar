import Alpine from 'alpinejs';

const root = document.documentElement;
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ---------------------------------------------------------------------------
 * Theme controller (light / system / dark)
 * ------------------------------------------------------------------------- */
const THEME_KEY = 'theme';
const THEME_TRANSITION_CLASS = 'theme-transition';
const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

let themeTransitionTimer;

const getStoredTheme = () => {
    try {
        return localStorage.getItem(THEME_KEY) || 'system';
    } catch {
        return 'system';
    }
};

const resolveTheme = (theme) => (theme === 'system' ? (systemTheme.matches ? 'dark' : 'light') : theme);

const applyTheme = (theme) => {
    root.classList.toggle('dark', resolveTheme(theme) === 'dark');
    root.dataset.theme = theme;

    const store = Alpine.store('theme');

    if (store) {
        store.current = theme;
    }
};

const setTheme = (theme) => {
    try {
        localStorage.setItem(THEME_KEY, theme);
    } catch {
        /* localStorage unavailable (private mode) - theme still applies for the session. */
    }

    if (!prefersReducedMotion) {
        root.classList.add(THEME_TRANSITION_CLASS);
        clearTimeout(themeTransitionTimer);
        themeTransitionTimer = window.setTimeout(() => root.classList.remove(THEME_TRANSITION_CLASS), 350);
    }

    applyTheme(theme);
};

/* ---------------------------------------------------------------------------
 * Alpine stores: shared state for the theme dropdown and the mobile drawer.
 * ------------------------------------------------------------------------- */
Alpine.store('theme', {
    current: getStoredTheme(),
    set(value) {
        setTheme(value);
    },
});

Alpine.store('nav', {
    open: false,
});

Alpine.start();

systemTheme.addEventListener('change', () => {
    if (getStoredTheme() === 'system') {
        applyTheme('system');
    }
});

applyTheme(getStoredTheme());

/* ---------------------------------------------------------------------------
 * Floating navbar + back-to-top visibility.
 * One IntersectionObserver on a sentinel at the top of the layout avoids a
 * per-frame scroll listener.
 * ------------------------------------------------------------------------- */
const sentinel = document.getElementById('top-sentinel');
const navbar = document.querySelector('[data-navbar]');
const backToTop = document.querySelector('[data-back-to-top]');

if (sentinel && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
        ([entry]) => {
            const scrolled = !entry.isIntersecting;

            navbar?.classList.toggle('is-scrolled', scrolled);

            if (backToTop) {
                backToTop.classList.toggle('opacity-0', !scrolled);
                backToTop.classList.toggle('pointer-events-none', !scrolled);
                backToTop.classList.toggle('translate-y-2', !scrolled);
            }
        },
        { threshold: 0 },
    );

    observer.observe(sentinel);
}

/* ---------------------------------------------------------------------------
 * Back-to-top button.
 * ------------------------------------------------------------------------- */
backToTop?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
});
