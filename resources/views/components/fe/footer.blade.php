@php
    // TODO: arahkan setiap tautan ke halaman yang sebenarnya.
    $navLinks = [
        ['label' => 'Beranda', 'href' => route('home')],
        ['label' => 'Tentang', 'href' => route('tentang')],
        ['label' => 'Kegiatan', 'href' => route('kegiatan.index')],
        ['label' => 'Berita', 'href' => route('berita')],
        ['label' => 'Galeri', 'href' => route('galeri')],
        ['label' => 'Kontak', 'href' => route('kontak')],
    ];

    // TODO: ganti dengan akun sosial media gereja.
    $socialLinks = [
        ['label' => 'Instagram', 'href' => '#', 'icon' => 'instagram'],
        ['label' => 'Facebook', 'href' => '#', 'icon' => 'facebook'],
        ['label' => 'YouTube', 'href' => '#', 'icon' => 'youtube'],
    ];

    $services = [
        ['session' => 'Sesi Pagi', 'time' => '08.00', 'place' => 'Bulakan Sari, Nusa Dua'],
        ['session' => 'Sesi Sore', 'time' => '17.00', 'place' => 'Sekretariat, Denpasar'],
    ];

    // TODO: ganti dengan data gereja yang sebenarnya.
    $contact = [
        'address' => 'Jl. Teuku Umar No. 120, Denpasar Barat, Kota Denpasar, Bali 80113',
        'maps' => 'https://maps.google.com/?q=Denpasar+Bali',
        'phone' => '+62 812-3456-7890',
        'phoneHref' => 'tel:+6281234567890',
        'email' => 'info@gkkd-denpasar.test',
    ];

    // Footer selalu gelap, terlepas dari tema halaman.
    $linkClass = 'text-sm text-neutral-300 transition-colors hover:text-accent-soft';
    $labelClass = 'text-xs font-medium text-neutral-400';
    $focusRing = 'rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-950';
@endphp

<footer class="mt-24 overflow-hidden bg-neutral-950 text-neutral-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Ajakan utama + jadwal ibadah --}}
        <div class="grid gap-12 border-b border-white/10 py-14 lg:grid-cols-12 lg:gap-16 lg:py-20">
            <div class="lg:col-span-7">
                <div class="flex items-center gap-2.5">
                    <span class="relative h-9 w-9 shrink-0 overflow-hidden rounded-full bg-[#121212] ring-1 ring-white/15">
                        <img
                            src="{{ asset('images/logo.jpeg') }}"
                            alt="Logo GKKD Denpasar"
                            width="36"
                            height="36"
                            class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"
                        >
                    </span>
                    <span class="text-lg font-semibold tracking-tight sm:text-xl">Gereja Kristen Kemah Daud Denpasar</span>
                </div>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-neutral-400">
                    Rumah rohani untuk bertumbuh dalam iman dan melayani kota Denpasar.
                </p>

                <a href="{{ route('kontak') }}" class="{{ $linkClass }} {{ $focusRing }} mt-6 inline-flex items-center gap-1.5">
                    Lihat jadwal &amp; lokasi
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16m-6-6 6 6-6 6" />
                    </svg>
                </a>
            </div>

            <div class="lg:col-span-5 lg:w-full lg:max-w-sm lg:justify-self-end">
                <h3 class="{{ $labelClass }}">Jadwal Ibadah</h3>
                <dl class="mt-5 divide-y divide-white/10 border-y border-white/10">
                    @foreach ($services as $service)
                        <div class="py-4">
                            <div class="flex items-baseline justify-between gap-4">
                                <dt class="text-sm text-neutral-300">{{ $service['session'] }}</dt>
                                <dd class="text-2xl font-semibold tracking-tight tabular-nums">
                                    {{ $service['time'] }}
                                    <span class="text-sm font-normal text-neutral-400">WITA</span>
                                </dd>
                            </div>
                            <p class="mt-1 text-sm text-neutral-400">{{ $service['place'] }}</p>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>

        {{-- Tautan, lokasi, dan sosial media --}}
        <div class="grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <h3 class="{{ $labelClass }}">Jelajahi</h3>
                <ul class="mt-5 grid grid-cols-2 gap-x-6 gap-y-3">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="{{ $linkClass }} {{ $focusRing }}">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h3 class="{{ $labelClass }}">Lokasi &amp; Kontak</h3>
                <div class="mt-5 space-y-3 text-sm text-neutral-300">
                    <a
                        href="{{ $contact['maps'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block max-w-xs leading-relaxed transition-colors hover:text-accent-soft {{ $focusRing }}"
                    >
                        {{ $contact['address'] }}
                    </a>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <a href="{{ $contact['phoneHref'] }}" class="{{ $linkClass }} {{ $focusRing }}">{{ $contact['phone'] }}</a>
                        <a href="mailto:{{ $contact['email'] }}" class="{{ $linkClass }} {{ $focusRing }}">{{ $contact['email'] }}</a>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-2 lg:col-span-3 lg:justify-self-end">
                <h3 class="{{ $labelClass }}">Media Sosial</h3>
                <div class="mt-5 flex items-center gap-3">
                    @foreach ($socialLinks as $social)
                        <a
                            href="{{ $social['href'] }}"
                            aria-label="{{ $social['label'] }}"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-neutral-300 transition-colors hover:bg-accent hover:text-white {{ $focusRing }}"
                        >
                            @if ($social['icon'] === 'instagram')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                </svg>
                            @elseif ($social['icon'] === 'facebook')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M13.5 21v-7h2.4l.4-2.9h-2.8V9.3c0-.8.2-1.4 1.4-1.4h1.5V5.3c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2.1H8v2.9h2.5V21h3Z" />
                                </svg>
                            @else
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.6 7.2c-.2-.9-.9-1.6-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4c-.9.2-1.6.9-1.8 1.8C2 8.8 2 12 2 12s0 3.2.4 4.8c.2.9.9 1.6 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4c.9-.2 1.6-.9 1.8-1.8.4-1.6.4-4.8.4-4.8s0-3.2-.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z" />
                                </svg>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-6 text-center text-xs text-neutral-400 sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} Gereja Kristen Kemah Daud Denpasar. Hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
