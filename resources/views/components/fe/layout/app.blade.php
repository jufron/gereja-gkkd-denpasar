@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'GKKD Denpasar') }}</title>

        @if ($description)
            <meta name="description" content="{{ $description }}">
        @endif

        <link rel="canonical" href="{{ url()->current() }}">

        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ config('app.name', 'GKKD Denpasar') }}">
        <meta property="og:title" content="{{ $title ?? config('app.name', 'GKKD Denpasar') }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('images/logo.jpeg') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? config('app.name', 'GKKD Denpasar') }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ asset('images/logo.jpeg') }}">

        {{-- Set the theme before paint to avoid a flash of the wrong color scheme. --}}
        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('theme') || 'system';
                    var dark = theme === 'dark'
                        || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    document.documentElement.classList.toggle('dark', dark);
                    document.documentElement.dataset.theme = theme;
                } catch (e) {}
            })();
        </script>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-CwDpOhRs.css') }}">
        <script src="{{ asset('build/assets/app-BdJKuoxM.js') }}" defer></script> --}}

        {{-- FullCalendar — hanya dibutuhkan di halaman home. defer=mencegah render-blocking. --}}
        @if (request()->routeIs('home'))
            <script defer src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        @endif

        @stack('head')

        @livewireStyles
    </head>
    <body class="min-h-screen bg-surface font-sans text-ink antialiased">
        <div id="top-sentinel" aria-hidden="true" class="absolute top-0 left-0 h-px w-full"></div>

        <a
            href="#main"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-full focus:bg-accent focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-white"
        >
            Lewati ke konten
        </a>

        <x-fe.navbar />

        <x-logout-modal />

        <main id="main">
            {{ $slot }}
        </main>

        <x-fe.footer :flush="request()->routeIs('kegiatan.pelayanan')" />

        <x-fe.whatsapp-button />
        <x-fe.back-to-top />

        @stack('scripts')

        @livewireScripts
    </body>
</html>
