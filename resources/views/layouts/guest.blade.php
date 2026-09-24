<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GKKD Denpasar') }}</title>

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
    </head>
    <body class="min-h-[100dvh] bg-surface font-sans text-ink antialiased">
        <div class="grid min-h-[100dvh] lg:grid-cols-[1.05fr_1fr]">
            {{-- Brand panel: real sanctuary photo under a dark scrim, not a hand-rolled illustration. --}}
            <aside class="relative hidden overflow-hidden bg-darkbase lg:flex">
                <img
                    src="{{ asset('images/church-sanctuary.jpg') }}"
                    alt=""
                    aria-hidden="true"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-black/35"></div>
                <div
                    class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-accent/25 blur-3xl"
                    aria-hidden="true"
                ></div>

                <div class="relative z-10 flex w-full flex-col justify-between p-10 xl:p-14">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 self-start rounded-full">
                        <span class="h-10 w-10 overflow-hidden rounded-full bg-white/10 ring-1 ring-white/20">
                            <img
                                src="{{ asset('images/logo.jpeg') }}"
                                alt="Logo GKKD Denpasar"
                                class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"
                            >
                        </span>
                        <span class="text-base font-semibold tracking-tight text-white">GKKD Denpasar</span>
                    </a>

                    <div class="max-w-md">
                        <p class="font-semibold uppercase tracking-[0.2em] text-accent-soft text-[11px]">
                            Gereja Kerapatan Injil Kerajaan Allah
                        </p>
                        <p class="mt-4 font-serif text-2xl leading-snug text-white xl:text-3xl">
                            &ldquo;Masuklah melalui-Nya dengan ucapan syukur, masuklah ke pelataran-Nya dengan puji-pujian.&rdquo;
                        </p>
                        <p class="mt-3 text-sm text-white/60">Mazmur 100:4</p>
                    </div>

                    <p class="text-xs text-white/40">&copy; {{ date('Y') }} GKKD Denpasar. Semua hak dilindungi.</p>
                </div>
            </aside>

            {{-- Form panel. --}}
            <main class="flex items-center justify-center p-6 sm:p-10">
                <div class="w-full max-w-md">
                    <div class="mb-8 flex items-center gap-3 lg:hidden">
                        <span class="h-10 w-10 overflow-hidden rounded-full bg-[#121212] ring-1 ring-ink/10"><img src="{{ asset("images/logo.jpeg") }}" alt="Logo GKKD Denpasar" class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"></span>
                        <span class="text-base font-semibold tracking-tight">GKKD Denpasar</span>
                    </div>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
