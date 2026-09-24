@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-canvas">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'GKKD Denpasar') }} - Church Dashboard</title>

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

        @stack('head')

        @livewireStyles
    </head>
    <body class="m-0 w-full min-h-screen bg-canvas font-sans text-ink antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">
        <!-- MOBILE SIDEBAR BACKDROP OVERLAY -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
            style="display: none;"
        ></div>

        <div class="relative flex min-h-screen w-full">
            <x-be.sidebar />

            <div class="flex min-h-screen w-full min-w-0 flex-1 flex-col overflow-x-hidden lg:pl-64">
                <x-be.topbar :title="$title" :description="$description" />

                <main class="flex-1 p-4 lg:p-8">
                    {{ $slot }}
                </main>

                <x-be.footer />
            </div>
        </div>

        <x-logout-modal />

        @stack('scripts')

        @livewireScripts
    </body>
</html>
