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

        {{-- FullCalendar CDN (terintegrasi dengan layout FlyonUI / Tailwind CSS) --}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

        @stack('head')
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

        <main id="main">
            {{ $slot }}
        </main>

        <x-fe.footer />

        <x-fe.whatsapp-button />
        <x-fe.back-to-top />

        @stack('scripts')
    </body>
</html>
