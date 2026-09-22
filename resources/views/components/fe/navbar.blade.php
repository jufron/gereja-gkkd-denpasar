@php
    // TODO: ganti dengan nomor WhatsApp gereja (format internasional tanpa "+").
    $whatsappNumber = '6281234567890';
    $whatsappMessage = rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.');

    // TODO: arahkan setiap tautan ke halaman yang sebenarnya.
    // Definisi nav links dengan penanganan routeIs yang presisi
    $navLinks = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home') || request()->is('/')],
        ['label' => 'Tentang', 'href' => route('tentang'), 'active' => request()->routeIs('tentang')],
        [
            'label' => 'Kegiatan',
            'href' => route('kegiatan.index'),
            'active' => request()->routeIs('kegiatan.*'),
            'children' => [
                ['label' => 'Pelayanan', 'href' => route('kegiatan.pelayanan'), 'active' => request()->routeIs('kegiatan.pelayanan')],
                ['label' => 'Komsel', 'href' => route('kegiatan.komsel'), 'active' => request()->routeIs('kegiatan.komsel')],
                ['label' => 'Retret/Camp 12', 'href' => route('kegiatan.retret-camp'), 'active' => request()->routeIs('kegiatan.retret-camp')],
            ],
        ],
        ['label' => 'Berita', 'href' => route('berita'), 'active' => request()->routeIs('berita*')],
        ['label' => 'Galeri', 'href' => route('galeri'), 'active' => request()->routeIs('galeri')],
        ['label' => 'Kontak', 'href' => route('kontak'), 'active' => request()->routeIs('kontak')],
    ];

    // Auth belum terpasang; tombol otomatis memakai route login begitu tersedia.
    $loginUrl = Route::has('login') ? route('login') : '#';

    $linkBase = 'rounded-full px-3.5 py-2 text-sm font-medium transition-colors hover:text-accent dark:hover:text-accent-soft';
    $activeClass = 'bg-accent/10 font-semibold text-accent dark:bg-accent/20 dark:text-accent-soft';
    $inactiveClass = 'text-ink/70 hover:bg-ink/5 dark:text-muted';
    $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
@endphp

<header data-navbar x-data class="sticky top-0 z-40 w-full">
    <div class="nav-shell px-4 sm:px-6 lg:px-8">
        <div class="grid h-16 grid-cols-[auto_1fr_auto] items-center gap-3 lg:grid-cols-[1fr_auto_1fr]">
            {{-- Kiri: logo + nama brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 justify-self-start rounded-full {{ $focusRing }}">
                <span class="relative h-9 w-9 shrink-0 overflow-hidden rounded-full bg-[#121212] ring-1 ring-ink/10">
                    {{-- JPEG berlatar hitam: di-crop ke emblem di dalam chip gelap. Nilai crop mungkin perlu disetel. --}}
                    <img
                        src="{{ asset('images/logo.jpeg') }}"
                        alt="Logo GKKD Denpasar"
                        width="36"
                        height="36"
                        class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"
                    >
                </span>
                <span class="hidden text-base font-semibold tracking-tight text-ink sm:inline">GKKD Denpasar</span>
            </a>

            {{-- Tengah: 6 tautan (desktop) --}}
            <nav class="hidden items-center justify-self-center lg:flex" aria-label="Navigasi utama">
                @foreach ($navLinks as $link)
                    @if (! empty($link['children']))
                        <div class="group relative">
                            <button
                                type="button"
                                class="{{ $linkBase }} {{ $link['active'] ? $activeClass : $inactiveClass }} {{ $focusRing }} inline-flex items-center gap-1"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                {{ $link['label'] }}
                                <svg class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div class="invisible absolute top-full left-1/2 z-50 w-56 -translate-x-1/2 translate-y-1 pt-2 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 motion-reduce:transition-none">
                                <div class="glass-nav rounded-2xl p-2">
                                    <a href="{{ $link['href'] }}" class="block rounded-xl px-3 py-2 text-xs font-semibold uppercase tracking-wider text-muted/70 transition-colors hover:bg-accent/10 hover:text-accent dark:hover:text-accent-soft">
                                        Semua Kegiatan &rarr;
                                    </a>
                                    @foreach ($link['children'] as $child)
                                        <a
                                            href="{{ $child['href'] }}"
                                            @if ($child['active'] ?? false) aria-current="page" @endif
                                            class="block rounded-xl px-3 py-2 text-sm transition-colors {{ ($child['active'] ?? false) ? 'bg-accent/10 font-semibold text-accent dark:bg-accent/20 dark:text-accent-soft' : 'text-muted hover:bg-accent/10 hover:text-accent dark:hover:text-accent-soft' }}"
                                        >
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a
                            href="{{ $link['href'] }}"
                            @if ($link['active'] ?? false) aria-current="page" @endif
                            class="{{ $linkBase }} {{ ($link['active'] ?? false) ? $activeClass : $inactiveClass }} {{ $focusRing }}"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Kanan: aksi --}}
            <div class="flex items-center gap-1.5 justify-self-end">
                {{-- Dropdown tema (desktop & mobile) --}}
                <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                    <button
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-haspopup="menu"
                        class="inline-flex h-10 items-center gap-1.5 rounded-full px-2.5 text-ink transition-colors hover:bg-ink/5 {{ $focusRing }}"
                    >
                        <span class="sr-only">Pilih tema</span>
                        <svg x-show="$store.theme.current === 'light'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <circle cx="12" cy="12" r="4" />
                            <path stroke-linecap="round" d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                        </svg>
                        <svg x-show="$store.theme.current === 'system'" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="12" rx="2" />
                            <path stroke-linecap="round" d="M8 20h8" />
                        </svg>
                        <svg x-show="$store.theme.current === 'dark'" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5Z" />
                        </svg>
                        <svg class="h-4 w-4 text-muted transition-transform duration-200 motion-reduce:transition-none" :class="open && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-cloak
                        @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-95"
                        role="menu"
                        class="absolute top-full right-0 z-50 mt-2 w-44 origin-top-right"
                    >
                        <div class="glass-nav rounded-2xl p-2">
                            @foreach (['light' => 'Terang', 'system' => 'Sistem', 'dark' => 'Gelap'] as $value => $label)
                                <button
                                    type="button"
                                    role="menuitemradio"
                                    @click="$store.theme.set('{{ $value }}'); open = false"
                                    :aria-pressed="$store.theme.current === '{{ $value }}'"
                                    class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-muted transition-colors hover:bg-accent/10 hover:text-accent aria-pressed:bg-accent/10 aria-pressed:text-accent dark:hover:text-accent-soft {{ $focusRing }}"
                                >
                                    @if ($value === 'light')
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <circle cx="12" cy="12" r="4" />
                                            <path stroke-linecap="round" d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                                        </svg>
                                    @elseif ($value === 'system')
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <rect x="3" y="4" width="18" height="12" rx="2" />
                                            <path stroke-linecap="round" d="M8 20h8" />
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5Z" />
                                        </svg>
                                    @endif
                                    <span>{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tombol Masuk (desktop) --}}
                <a
                    href="{{ $loginUrl }}"
                    class="hidden rounded-full bg-accent px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-accent-strong lg:inline-flex {{ $focusRing }}"
                >
                    Masuk
                </a>

                {{-- Hamburger (mobile) --}}
                <button
                    type="button"
                    @click="$store.nav.open = !$store.nav.open"
                    :aria-expanded="$store.nav.open"
                    aria-controls="mobile-menu"
                    class="grid h-10 w-10 place-items-center rounded-full text-ink transition-colors hover:bg-ink/5 lg:hidden {{ $focusRing }}"
                >
                    <span class="sr-only">Buka menu</span>
                    <svg x-show="!$store.nav.open" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                    <svg x-show="$store.nav.open" x-cloak class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Overlay drawer (mobile) --}}
<div
    x-data
    x-show="$store.nav.open"
    x-cloak
    @click="$store.nav.open = false"
    x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm lg:hidden"
></div>

{{-- Drawer menu (mobile): meluncur dari kiri ke kanan --}}
<aside
    id="mobile-menu"
    x-data
    x-show="$store.nav.open"
    x-cloak
    x-effect="document.body.classList.toggle('overflow-hidden', $store.nav.open)"
    @keydown.escape.window="$store.nav.open = false"
    aria-label="Menu navigasi"
    x-transition:enter="transition ease-[cubic-bezier(0.16,1,0.3,1)] duration-300 motion-reduce:transition-none"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 motion-reduce:transition-none"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 z-50 flex w-[85%] max-w-xs flex-col border-r border-line bg-surface/95 backdrop-blur-2xl lg:hidden"
>
    <div class="flex h-16 items-center justify-between border-b border-line px-4">
        <span class="flex items-center gap-2.5">
            <span class="relative h-9 w-9 shrink-0 overflow-hidden rounded-full bg-[#121212] ring-1 ring-ink/10">
                <img
                    src="{{ asset('images/logo.jpeg') }}"
                    alt="Logo GKKD Denpasar"
                    width="36"
                    height="36"
                    class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"
                >
            </span>
            <span class="text-base font-semibold tracking-tight text-ink">GKKD Denpasar</span>
        </span>
        <button
            type="button"
            @click="$store.nav.open = false"
            class="grid h-10 w-10 place-items-center rounded-full text-ink transition-colors hover:bg-ink/5 {{ $focusRing }}"
        >
            <span class="sr-only">Tutup menu</span>
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-2" aria-label="Navigasi mobile">
        @foreach ($navLinks as $link)
            @if (! empty($link['children']))
                <details class="group" @if($link['active'] ?? false) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl px-3 py-2.5 text-base font-medium transition-colors hover:bg-ink/5 [&::-webkit-details-marker]:hidden {{ ($link['active'] ?? false) ? 'text-accent font-semibold dark:text-accent-soft' : 'text-ink' }}">
                        {{ $link['label'] }}
                        <svg class="h-4 w-4 transition-transform duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>
                    <div class="mt-1 space-y-1 pl-3">
                        <a href="{{ $link['href'] }}" @click="$store.nav.open = false" class="block rounded-xl px-3 py-2 text-xs font-semibold uppercase tracking-wider text-muted/70 transition-colors hover:bg-accent/10 hover:text-accent">
                            Semua Kegiatan &rarr;
                        </a>
                        @foreach ($link['children'] as $child)
                            <a
                                href="{{ $child['href'] }}"
                                @click="$store.nav.open = false"
                                @if ($child['active'] ?? false) aria-current="page" @endif
                                class="block rounded-xl px-3 py-2 text-sm transition-colors {{ ($child['active'] ?? false) ? 'bg-accent/10 font-semibold text-accent dark:text-accent-soft' : 'text-muted hover:bg-accent/10 hover:text-accent dark:hover:text-accent-soft' }}"
                            >
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                <a
                    href="{{ $link['href'] }}"
                    @click="$store.nav.open = false"
                    @if ($link['active'] ?? false) aria-current="page" @endif
                    class="block rounded-xl px-3 py-2.5 text-base font-medium transition-colors hover:bg-ink/5 {{ ($link['active'] ?? false) ? 'bg-accent/10 font-semibold text-accent dark:text-accent-soft' : 'text-ink' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endif
        @endforeach
    </nav>

    <div class="border-t border-line p-4">
        <a
            href="{{ $loginUrl }}"
            @click="$store.nav.open = false"
            class="block rounded-full bg-accent px-5 py-2.5 text-center text-base font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
        >
            Masuk
        </a>
    </div>
</aside>
