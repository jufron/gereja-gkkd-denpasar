<x-fe.layout.app
    title="GKKD Denpasar — Gereja Kristen Kemah Daud"
    description="GKKD Denpasar adalah keluarga rohani yang bertumbuh dalam iman dan melayani kota Denpasar, Bali."
>
    @push('head')
        @php
            $churchUrl = url('/');
            $churchName = 'Gereja Kristen Kemah Daud Denpasar';

            $churchSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Church',
                '@id' => $churchUrl.'#church',
                'name' => $churchName,
                'alternateName' => 'GKKD Denpasar',
                'url' => $churchUrl,
                'image' => asset('images/logo.jpeg'),
                'description' => 'GKKD Denpasar adalah keluarga rohani yang bertumbuh dalam iman dan melayani kota Denpasar, Bali.',
                'telephone' => '+6281234567890',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Jl. Teuku Umar No. 120, Denpasar Barat',
                    'addressLocality' => 'Denpasar',
                    'addressRegion' => 'Bali',
                    'postalCode' => '80113',
                    'addressCountry' => 'ID',
                ],
                'geo' => ['@type' => 'GeoCoordinates', 'latitude' => -8.6434, 'longitude' => 115.2147],
                'openingHoursSpecification' => [
                    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Sunday', 'opens' => '08:00', 'closes' => '12:00'],
                    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Sunday', 'opens' => '17:00', 'closes' => '20:00'],
                ],
            ];

            $websiteSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => $churchUrl.'#website',
                'url' => $churchUrl,
                'name' => $churchName,
                'inLanguage' => 'id-ID',
                'publisher' => ['@id' => $churchUrl.'#church'],
            ];

            $eventSchema = array_map(fn ($e) => array_filter([
                '@type' => 'Event',
                'name' => $e['title'],
                'startDate' => $e['start'] ?? null,
                'endDate' => $e['end'] ?? null,
                'location' => [
                    '@type' => 'Place',
                    'name' => $churchName,
                    'address' => $churchSchema['address'],
                ],
            ]), $calendarEvents ?? []);

            $schemaBlock = array_merge([$churchSchema, $websiteSchema], $eventSchema);
        @endphp
        <script type="application/ld+json">@json($schemaBlock)</script>
    @endpush

    {{-- Hero --}}
    <section
        class="relative overflow-hidden bg-ink -mt-[var(--nav-h)]"
        x-data="{
            current: 0,
            total: {{ count($heroBanners) }},
            playing: true,
            autoplayTimer: null,
            touchStartX: 0,
            touchEndX: 0,
            captions: [],
            init() {
                const el = document.getElementById('hero-captions');
                this.captions = el ? JSON.parse(el.textContent) : [];
                this.$watch('playing', () => this.playing ? this.startAutoplay() : this.stopAutoplay());
                this.startAutoplay();
                window.addEventListener('focus', () => { if (this.playing) this.startAutoplay(); });
                window.addEventListener('blur', () => this.stopAutoplay());
            },
            startAutoplay() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                this.stopAutoplay();
                this.autoplayTimer = setInterval(() => this.next(), 5000);
            },
            stopAutoplay() {
                if (this.autoplayTimer) { clearInterval(this.autoplayTimer); this.autoplayTimer = null; }
            },
            togglePlay() { this.playing = !this.playing; },
            next() { this.current = (this.current + 1) % this.total; },
            prev() { this.current = (this.current - 1 + this.total) % this.total; },
            goTo(index) { this.current = index; if (this.playing) this.startAutoplay(); },
            handleTouchStart(e) { this.touchStartX = e.touches[0].clientX; this.stopAutoplay(); },
            handleTouchEnd(e) {
                this.touchEndX = e.changedTouches[0].clientX;
                const diff = this.touchStartX - this.touchEndX;
                if (Math.abs(diff) > 40) { if (diff > 0) this.next(); else this.prev(); }
                if (this.playing) this.startAutoplay();
            }
        }"
        @touchstart.passive="handleTouchStart($event)"
        @touchend.passive="handleTouchEnd($event)"
        @keydown.left.prevent="prev()"
        @keydown.right.prevent="next()"
    >
        <script type="application/json" id="hero-captions">@json(collect($heroBanners)->map(fn ($b) => ['badge' => $b['badge'], 'caption' => $b['caption']]))</script>

        {{-- Background slider --}}
        <div class="absolute inset-0">
            @foreach ($heroBanners as $index => $banner)
                <div
                    x-show="current === {{ $index }}"
                    x-transition:enter="transition-opacity ease-out duration-700"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-in duration-500 absolute inset-0"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 h-full w-full"
                >
                    <img
                        src="{{ $banner['image'] }}"
                        alt="{{ $banner['alt'] }}"
                        width="1600"
                        height="900"
                        @if ($index === 0) fetchpriority="high" @else loading="lazy" @endif
                        class="h-full w-full object-cover ken-burns"
                    >
                </div>
            @endforeach
        </div>

        {{-- Scrim untuk kontras teks --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/10 lg:to-black/5"></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-black/20"></div>

        {{-- Ambient glow --}}
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 h-96 w-96 rounded-full bg-accent/25 blur-3xl hero-float"></div>
        <div aria-hidden="true" class="pointer-events-none absolute right-0 bottom-10 h-80 w-80 rounded-full bg-accent/20 blur-3xl hero-float-slow"></div>

        {{-- Konten --}}
        <div class="relative mx-auto grid min-h-[86svh] max-w-7xl items-center gap-12 px-4 pt-[calc(var(--nav-h)+3.5rem)] pb-16 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8 lg:min-h-[88svh] lg:pt-[calc(var(--nav-h)+2rem)] lg:pb-0">
            {{-- Kolom teks --}}
            <div class="lg:col-span-7">
                <span class="inline-flex items-center gap-2.5 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-medium tracking-wide text-white backdrop-blur-md animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:60ms">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-accent-soft opacity-75 animate-ping"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-accent-soft"></span>
                    </span>
                    GKKD Denpasar &bull; Ibadah Tatap Muka &amp; Online
                </span>

                <h1 class="mt-6 text-white animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:140ms">
                    <span class="block font-display text-4xl leading-[1.1] text-white italic sm:text-5xl lg:text-6xl">
                        Rumah untuk bertumbuh
                    </span>
                    <span class="mt-2 block text-xl font-semibold tracking-tight text-white/90 sm:text-2xl lg:text-3xl">
                        dalam iman, kasih, dan pengharapan.
                    </span>
                </h1>

                <p class="mt-6 max-w-[56ch] text-base leading-relaxed text-white/75 sm:text-lg animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:220ms">
                    Gereja Kristen Kemah Daud (GKKD) Denpasar adalah keluarga rohani yang rindu menghadirkan hadirat Tuhan dan melayani sesama dengan ketulusan di Denpasar, Bali.
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-3 animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:300ms">
                    <a
                        href="#jadwal"
                        class="inline-flex min-h-11 items-center justify-center rounded-full bg-accent px-7 py-3 text-sm font-semibold text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                    >
                        Jadwal Ibadah
                    </a>
                    <a
                        href="{{ route('tentang') }}"
                        class="inline-flex min-h-11 items-center justify-center rounded-full border border-white/25 bg-white/5 px-7 py-3 text-sm font-semibold text-white backdrop-blur-md transition-colors hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                    >
                        Tentang Kami
                    </a>
                </div>

                {{-- Quick-fact strip --}}
                <dl class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4 border-t border-white/15 pt-6 text-sm text-white/70 animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:380ms">
                    <div class="flex items-center gap-2.5">
                        <svg class="h-4 w-4 shrink-0 text-accent-soft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        <dd class="font-medium text-white">Minggu 09.00 WITA</dd>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="h-4 w-4 shrink-0 text-accent-soft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 21s-7-5.5-7-11a7 7 0 0 1 14 0c0 5.5-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <dd class="font-medium text-white">Denpasar, Bali</dd>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="h-4 w-4 shrink-0 text-accent-soft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect width="18" height="12" x="3" y="7" rx="2"/><path d="m7 11 5 3 5-3"/></svg>
                        <dd class="font-medium text-white">Online tersedia</dd>
                    </div>
                </dl>
            </div>

            {{-- Kolom kanan: glass card jadwal --}}
            <div class="hidden lg:block lg:col-span-5 animate-[hero-rise_0.8s_ease-out_both]" style="animation-delay:320ms">
                <div class="rounded-3xl border border-white/15 bg-white/10 p-7 shadow-2xl backdrop-blur-xl">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-bold text-white">Jadwal Pertemuan</h2>
                        <span class="shrink-0 rounded-full bg-accent/20 px-3 py-1 text-xs font-semibold text-white">Pekan Ini</span>
                    </div>
                    <ul class="mt-5 space-y-4">
                        @foreach (array_slice($schedules, 0, 3) as $schedule)
                            <li class="flex min-w-0 items-center justify-between gap-3 border-b border-white/10 pb-3 last:border-0 last:pb-0">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-white">{{ $schedule['title'] }}</p>
                                    <p class="mt-0.5 truncate text-xs text-white/60">{{ $schedule['day'] }}</p>
                                </div>
                                <span class="shrink-0 whitespace-nowrap rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white">{{ $schedule['time'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a
                        href="{{ route('kegiatan.index') }}"
                        class="mt-6 inline-flex min-h-11 w-full items-center justify-center rounded-full border border-white/25 bg-white/10 text-sm font-semibold text-white transition-colors hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft"
                    >
                        Lihat Semua Jadwal &rarr;
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom bar: caption + kontrol + progress (di dalam flow, tanpa overlap) --}}
        <div class="relative mx-auto max-w-7xl px-4 pb-6 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                {{-- Caption --}}
                <div class="pointer-events-none hidden min-w-0 flex-1 sm:block">
                    <div class="inline-block max-w-sm rounded-2xl border border-white/15 bg-black/40 px-5 py-4 backdrop-blur-md">
                        <span class="inline-block rounded-full bg-accent/90 px-2.5 py-0.5 text-[11px] font-semibold tracking-wider uppercase text-white">
                            <span x-text="captions[current]?.badge" x-cloak></span>
                        </span>
                        <p class="mt-1.5 text-sm font-semibold leading-snug text-white/95 line-clamp-2">
                            <span x-text="captions[current]?.caption" x-cloak></span>
                        </p>
                    </div>
                </div>

                {{-- Kontrol: prev / play-pause / next / counter / dots --}}
                <div class="ml-auto flex shrink-0 flex-col items-end gap-2.5">
                    <div class="flex items-center gap-2 rounded-full border border-white/15 bg-black/50 px-2.5 py-2 backdrop-blur-md">
                        <button type="button" @click="prev()" aria-label="Banner sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-full text-white transition-colors hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <button
                            type="button"
                            @click="togglePlay()"
                            :aria-label="playing ? 'Jeda otomatis banner' : 'Putar otomatis banner'"
                            aria-live="polite"
                            class="flex h-11 w-11 items-center justify-center rounded-full text-white transition-colors hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        >
                            <svg x-show="playing" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
                            <svg x-show="!playing" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                        <button type="button" @click="next()" aria-label="Banner berikutnya" class="flex h-11 w-11 items-center justify-center rounded-full text-white transition-colors hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                        <span class="select-none px-1 text-xs font-medium tabular-nums text-white/80" aria-live="polite">
                            <span x-text="current + 1"></span> / <span>{{ count($heroBanners) }}</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 rounded-full border border-white/15 bg-black/50 px-3 py-2 backdrop-blur-md">
                        @foreach ($heroBanners as $idx => $b)
                            <button
                                type="button"
                                @click="goTo({{ $idx }})"
                                :aria-current="current === {{ $idx }} ? 'true' : 'false'"
                                aria-label="Ke banner {{ $idx + 1 }}"
                                class="h-2.5 rounded-full transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                :class="current === {{ $idx }} ? 'w-7 bg-accent-soft' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                            ></button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Progress bar autoplay --}}
            <div aria-hidden="true" class="mt-4 h-0.5 w-full overflow-hidden rounded-full bg-white/20">
                <div class="h-full origin-left rounded-full bg-accent-soft" :class="playing ? 'autoplay-progress-running' : ''"></div>
            </div>
        </div>

        {{-- Scroll cue --}}
        <div aria-hidden="true" class="pointer-events-none absolute bottom-0 left-1/2 hidden -translate-x-1/2 pb-4 lg:block animate-[hero-rise_0.7s_ease-out_both]" style="animation-delay:900ms">
            <div class="flex h-9 w-6 items-start justify-center rounded-full border border-white/25 p-1.5">
                <span class="h-2 w-1 rounded-full bg-white/70 animate-[scroll-wheel_1.8s_ease-in-out_infinite]"></span>
            </div>
        </div>
    </section>


    {{-- Sambutan + Jadwal Ibadah --}}
    <section id="jadwal" class="border-t border-line bg-ink/5 py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Jadwal Pertemuan & Ibadah
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Setiap orang diterima apa adanya. Anda dan keluarga diundang untuk bersekutu bersama kami di Denpasar.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($schedules as $schedule)
                    <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <span class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-semibold {{ $schedule['badge_color'] ?? 'bg-accent/10 text-accent dark:text-accent-soft' }}">
                            {{ $schedule['badge'] }}
                        </span>
                        <h3 class="mt-4 text-xl font-semibold text-ink">{{ $schedule['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">
                            {{ $schedule['desc'] }}
                        </p>
                        <dl class="mt-6 space-y-3 border-t border-line pt-4 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-muted">Hari</dt>
                                <dd class="font-semibold text-ink">{{ $schedule['day'] }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-muted">Waktu</dt>
                                <dd class="font-semibold text-ink">{{ $schedule['time'] }}</dd>
                            </div>
                        </dl>
                    </div>
                @endforeach
            </div>

            {{-- 1 Tombol: Lihat Jadwal Pertemuan & Ibadah Lainnya --}}
            <div class="mt-12 text-center" data-reveal>
                <a
                    href="{{ route('kegiatan.index') }}"
                    class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
                >
                    Lihat Jadwal Pertemuan & Ibadah Lainnya &rarr;
                </a>
            </div>
        </div>
    </section>

    {{-- Rangkuman Khotbah (Spread Editorial: Foto + Verse Chip + Blockquote) --}}
    <section class="border-t border-line py-16 lg:py-20" aria-labelledby="heading-rangkuman-khotbah">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end" data-reveal>
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                        Pesan Mimbar Terbaru
                    </span>
                    <h2 id="heading-rangkuman-khotbah" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                        Rangkuman Khotbah
                    </h2>
                    <p class="mt-2 text-base leading-relaxed text-muted">
                        Pokok-pokok firman Tuhan yang telah disampaikan dalam ibadah jemaat GKKD Denpasar.
                    </p>
                </div>
                <a
                    href="{{ route('kegiatan.index') }}"
                    class="group inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-accent dark:text-accent-soft hover:underline underline-offset-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent rounded-full px-3 py-1.5"
                >
                    Semua Khotbah
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 motion-reduce:group-hover:translate-x-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            {{-- Kartu Utama --}}
            <div class="group mt-10 grid overflow-hidden rounded-3xl border border-line bg-surface shadow-sm transition-all hover:border-accent/40 hover:shadow-md lg:grid-cols-12">
                {{-- Kolom Foto (5/12) --}}
                <div class="relative aspect-[4/5] w-full overflow-hidden bg-ink/5 sm:aspect-[16/10] lg:col-span-5 lg:aspect-auto" data-reveal>
                    <img
                        src="{{ $featuredSermon['image'] }}"
                        alt="{{ $featuredSermon['image_alt'] }}"
                        width="600"
                        height="600"
                        loading="lazy"
                        class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.04] motion-reduce:transform-none"
                    >
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <span class="absolute top-4 left-4 rounded-full bg-accent/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white backdrop-blur-xs">
                        {{ $featuredSermon['label'] }}
                    </span>
                </div>

                {{-- Kolom Informasi (7/12) --}}
                <div class="flex flex-col justify-between p-6 sm:p-8 lg:col-span-7 lg:p-10" data-reveal style="transition-delay:80ms">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                {{ $featuredSermon['category'] }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs text-muted">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                                </svg>
                                {{ $featuredSermon['date'] }}
                            </span>
                        </div>

                        <h3 class="mt-4 font-display text-3xl leading-tight font-normal tracking-tight text-ink sm:text-4xl">
                            {{ $featuredSermon['title'] }}
                        </h3>

                        <div class="mt-4 flex flex-wrap items-center gap-2.5 text-sm">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent/10 text-accent dark:text-accent-soft" aria-hidden="true">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <span class="font-medium text-ink">{{ $featuredSermon['preacher'] }}</span>
                            <span class="text-xs text-muted">Pengkhotbah</span>
                        </div>

                        <p class="mt-5 text-base leading-relaxed text-muted line-clamp-3">
                            {{ $featuredSermon['excerpt'] }}
                        </p>
                    </div>

                    {{-- Action --}}
                    <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line pt-6">
                        <a
                            href="{{ $featuredSermon['detail_url'] }}"
                            class="inline-flex min-h-11 items-center gap-2 rounded-full bg-accent px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            <span>Lihat Detail Khotbah</span>
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <button
                            type="button"
                            disabled
                            title="Slide PPT belum tersedia"
                            class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-5 py-3 text-sm font-medium text-muted cursor-not-allowed opacity-60"
                        >
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                            </svg>
                            Unduh Slide PPT
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Ringkasan Berita --}}
    <section class="border-t border-line py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end" data-reveal>
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                        Kabar Jemaat
                    </span>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                        Kabar & Berita Terkini
                    </h2>
                    <p class="mt-2 text-base leading-relaxed text-muted">
                        Dokumentasi liputan pelayanan, renungan firman, dan kabar sukacita jemaat GKKD Denpasar.
                    </p>
                </div>
                <a
                    href="{{ route('berita') }}"
                    class="group inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-accent dark:text-accent-soft hover:underline underline-offset-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent rounded-full px-3 py-1.5"
                >
                    Lihat Semua Berita
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 motion-reduce:group-hover:translate-x-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            @if (count($latestNews) === 0)
                <div class="mt-10 rounded-3xl border border-dashed border-line bg-surface p-12 text-center" data-reveal>
                    <p class="text-base font-medium text-ink">Belum ada berita terbaru.</p>
                    <p class="mt-2 text-sm text-muted">Kabar pelayanan akan segera hadir di sini.</p>
                </div>
            @else
                <div class="mt-10 grid gap-6 lg:grid-cols-12">
                    {{-- Kartu utama (lead) --}}
                    <article class="group overflow-hidden rounded-3xl border border-line bg-surface shadow-sm transition-all hover:border-accent/40 hover:shadow-md lg:col-span-7" data-reveal>
                        <a href="{{ $latestNews[0]['link'] }}" class="flex h-full flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-accent">
                            <div class="relative aspect-16/10 overflow-hidden bg-ink/5">
                                <img
                                    src="{{ $latestNews[0]['image'] }}"
                                    alt="{{ $latestNews[0]['title'] }}"
                                    width="800"
                                    height="500"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.04] motion-reduce:transform-none"
                                >
                                <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <span class="absolute top-4 left-4 rounded-full px-3 py-1 text-xs font-semibold {{ $latestNews[0]['category_color'] ?? 'bg-accent/90 text-white' }}">
                                    {{ $latestNews[0]['category'] }}
                                </span>
                            </div>
                            <div class="flex flex-1 flex-col justify-between p-6 sm:p-7">
                                <div>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-muted">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                            {{ $latestNews[0]['date'] }}
                                        </span>
                                        <span aria-hidden="true">&bull;</span>
                                        <span>{{ $latestNews[0]['read_time'] }}</span>
                                    </div>
                                    <h3 class="mt-3 text-xl font-semibold leading-snug text-ink sm:text-2xl">
                                        {{ $latestNews[0]['title'] }}
                                    </h3>
                                    <p class="mt-2 text-sm leading-relaxed text-muted line-clamp-3">
                                        {{ $latestNews[0]['summary'] }}
                                    </p>
                                </div>
                                <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-accent dark:text-accent-soft">
                                    Baca artikel
                                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 motion-reduce:group-hover:translate-x-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                                </span>
                            </div>
                        </a>
                    </article>

                    {{-- Kolom kanan: item ringkas --}}
                    <div class="space-y-6 lg:col-span-5">
                        @foreach (array_slice($latestNews, 1) as $news)
                            <article class="group flex gap-5 rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                                <a href="{{ $news['link'] }}" class="flex flex-1 items-start gap-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent rounded-xl">
                                    <div class="aspect-square w-24 shrink-0 overflow-hidden rounded-xl bg-ink/5 sm:w-28">
                                        <img
                                            src="{{ $news['image'] }}"
                                            alt="{{ $news['title'] }}"
                                            width="160"
                                            height="160"
                                            loading="lazy"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 motion-reduce:transform-none"
                                        >
                                    </div>
                                    <div class="min-w-0">
                                        <span class="inline-block rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $news['category_color'] ?? 'bg-accent/10 text-accent dark:text-accent-soft' }}">
                                            {{ $news['category'] }}
                                        </span>
                                        <h3 class="mt-2 text-base font-semibold leading-snug text-ink group-hover:text-accent dark:group-hover:text-accent-soft">
                                            {{ $news['title'] }}
                                        </h3>
                                        <div class="mt-1.5 flex flex-wrap items-center gap-x-2.5 gap-y-1 text-xs text-muted">
                                            <span>{{ $news['date'] }}</span>
                                            <span aria-hidden="true">&bull;</span>
                                            <span>{{ $news['read_time'] }}</span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 1 Tombol: Lihat Berita Lainnya --}}
            <div class="mt-12 text-center" data-reveal>
                <a
                    href="{{ route('berita') }}"
                    class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
                >
                    Lihat Berita Lainnya &rarr;
                </a>
            </div>
        </div>
    </section>


    {{-- Ringkasan Pengumuman Terbaru (Di bawah berita section) --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Pengumuman & Warta Terbaru
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Agenda penting jemaat, pendaftaran sakramen, dan informasi pelayanan terkini.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (array_slice($announcements, 0, 3) as $item)
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-sm" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $item['badge_color'] }}">
                                    {{ $item['tag'] }}
                                </span>
                                <span class="text-xs text-muted">{{ $item['date'] }}</span>
                            </div>
                            <h3 class="mt-3.5 text-lg font-semibold leading-snug text-ink">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                {{ $item['summary'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 1 Tombol: Pengumuman dan Warta Lainnya --}}
            <div class="mt-12 text-center" data-reveal>
                <a
                    href="{{ route('berita') }}"
                    class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
                >
                    Pengumuman dan Warta Lainnya &rarr;
                </a>
            </div>
        </div>
    </section>

    {{-- Section: Kalender Event & Agenda Gereja (FlyonUI / FullCalendar Layout) --}}
    {{-- Data event dipindah ke script JSON agar tanda kutip tidak memutus atribut x-data. --}}
    <script type="application/json" id="calendar-data">@json($calendarEvents)</script>
    <section class="border-t border-line py-16 lg:py-20" x-data="{
        calendarInitialDate: '{{ $calendarInitialDate }}',
        init() {
            if (typeof FullCalendar !== 'undefined' && this.$refs.calendarEl) {
                const calendar = new FullCalendar.Calendar(this.$refs.calendarEl, {
                    initialView: 'dayGridMonth',
                    initialDate: this.calendarInitialDate,
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next today'
                    },
                    events: JSON.parse(document.getElementById('calendar-data').textContent),
                    height: 'auto'
                });
                calendar.render();
            }
        }
    }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Agenda &amp; Kegiatan
                </span>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Kalender Event &amp; Agenda Gereja
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Integrasi FullCalendar &amp; FlyonUI: Kalender interaktif di sebelah kiri dan daftar lengkap event bulan ini di sebelah kanan.
                </p>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-12 items-start">
                {{-- Kiri (7 Columns): FullCalendar Widget --}}
                <div class="rounded-3xl border border-line bg-surface p-6 shadow-sm lg:col-span-7" data-reveal>
                    <div x-ref="calendarEl" class="fc-theme-tailwind text-sm"></div>
                </div>

                {{-- Kanan (5 Columns): Daftar Event Bulan Ini --}}
                <div class="space-y-4 lg:col-span-5" data-reveal style="transition-delay:80ms">
                    <div class="flex items-center justify-between border-b border-line pb-3">
                        <h3 class="text-base font-bold text-ink">Daftar Event Bulan Ini</h3>
                        <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs font-semibold text-accent dark:text-accent-soft">
                            {{ $calendarMonth }}
                        </span>
                    </div>

                    @foreach ($monthlyEvents as $event)
                        <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm" data-reveal style="transition-delay:{{ $loop->iteration * 60 }}ms">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl {{ $event['date_color'] }} font-bold">
                                    <span class="text-[10px] uppercase tracking-wider">{{ $event['month'] }}</span>
                                    <span class="text-base leading-none">{{ $event['day'] }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $event['tag_color'] }}">
                                        {{ $event['tag'] }}
                                    </span>
                                    <h4 class="mt-1.5 text-base font-semibold text-ink">{{ $event['title'] }}</h4>
                                    <p class="mt-1 text-xs text-muted">{{ $event['meta'] }}</p>
                                    <p class="mt-2 text-xs leading-relaxed text-muted">{{ $event['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Permohonan Doa --}}
    <section class="relative overflow-hidden border-t border-neutral-900 bg-[#101010] py-16 text-white lg:py-24">
        <div aria-hidden="true" class="pointer-events-none absolute -top-32 right-0 h-96 w-96 rounded-full bg-accent/20 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-14">
                <div class="lg:col-span-7" data-reveal>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1 text-xs font-medium text-neutral-300">
                        Pelayanan Doa
                    </span>
                    <h2 class="mt-5 font-display text-4xl leading-[1.15] font-normal tracking-tight text-white sm:text-5xl">
                        Tuhan mendengar.<br>Kami ikut berdoa.
                    </h2>
                    <p class="mt-4 max-w-[52ch] text-base leading-relaxed text-neutral-300">
                        Tidak perlu menunggu keadaan menjadi berat untuk meminta doa.
                        Bagikan pergumulan Anda — tim doa GKKD Denpasar akan mendoakan
                        secara pribadi, tanpa dipublikasikan.
                    </p>
                    <blockquote class="mt-6 max-w-[54ch] border-l-2 border-accent pl-5 text-sm italic leading-relaxed text-neutral-400">
                        "Janganlah hendaknya kamu kuatir tentang apa pun juga, tetapi nyatakanlah dalam segala hal keinginanmu kepada Allah dalam doa dan permohonan dengan ucapan syukur."
                        <footer class="mt-1.5 not-italic text-xs font-medium text-neutral-500">— Filipi 4:6</footer>
                    </blockquote>
                    <div class="mt-9 flex flex-wrap items-center gap-4">
                        <a
                            href="{{ route('doa') }}"
                            class="inline-flex min-h-11 items-center justify-center rounded-full bg-accent px-7 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft focus-visible:ring-offset-2 focus-visible:ring-offset-[#101010]"
                        >
                            Kirim Permohonan Doa &rarr;
                        </a>
                        <span class="text-xs text-neutral-400">Tanpa akun · ±2 menit</span>
                    </div>
                    <p class="mt-7 text-xs text-neutral-500">
                        <a href="{{ route('kebijakan-privasi') }}" class="underline decoration-neutral-600 underline-offset-4 transition-colors hover:text-neutral-300">
                            Baca kebijakan privasi &rarr;
                        </a>
                    </p>
                </div>

                <div class="lg:col-span-5" data-reveal style="transition-delay:80ms">
                    <div class="relative">
                        <div aria-hidden="true" class="pointer-events-none absolute -inset-4 -z-10 flex justify-end opacity-60">
                            <x-fe.prayer-illustration class="h-56 w-56 text-accent-soft/30" />
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-7 backdrop-blur-md sm:p-8">
                            <ol class="space-y-6">
                                <li class="flex gap-4">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-accent/40 bg-accent/15 text-sm font-semibold text-accent-soft">01</span>
                                    <div>
                                        <h3 class="text-base font-semibold text-white">Isi formulir</h3>
                                        <p class="mt-1 text-sm leading-relaxed text-neutral-400">Ceritakan pergumulan Anda — cukup ±2 menit.</p>
                                    </div>
                                </li>
                                <li class="flex gap-4">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-accent/40 bg-accent/15 text-sm font-semibold text-accent-soft">02</span>
                                    <div>
                                        <h3 class="text-base font-semibold text-white">Tim doa menerima</h3>
                                        <p class="mt-1 text-sm leading-relaxed text-neutral-400">Permohonan dibaca terbatas oleh tim doa gereja.</p>
                                    </div>
                                </li>
                                <li class="flex gap-4">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-accent/40 bg-accent/15 text-sm font-semibold text-accent-soft">03</span>
                                    <div>
                                        <h3 class="text-base font-semibold text-white">Didoakan & ditindaklanjuti</h3>
                                        <p class="mt-1 text-sm leading-relaxed text-neutral-400">Kami hubungi hanya bila Anda mengizinkan.</p>
                                    </div>
                                </li>
                            </ol>
                            <div class="mt-7 flex items-center gap-2.5 border-t border-white/10 pt-5 text-xs text-neutral-400">
                                <svg class="h-4 w-4 shrink-0 text-accent-soft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                Isi permohonan tidak pernah tampil di halaman publik.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Ajukan Persembahan dan Donasi --}}
    <section class="relative overflow-hidden border-t border-line py-16 lg:py-24" x-data="{
        copiedBca: false,
        copyAccount(number) {
            navigator.clipboard.writeText(number).then(() => {
                this.copiedBca = true;
                setTimeout(() => this.copiedBca = false, 2500);
            });
        }
    }">
        <div aria-hidden="true" class="pointer-events-none absolute -top-32 -left-24 h-96 w-96 rounded-full bg-accent/10 blur-3xl hero-float"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 right-0 h-80 w-80 rounded-full bg-accent/10 blur-3xl hero-float-slow"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Dukungan Pelayanan
                </span>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Persembahan dan Donasi
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Setiap persembahan dan donasi yang Anda berikan dikelola dengan penuh integritas untuk mendukung peribadahan, pembinaan jemaat, dan aksi kasih kemanusiaan di Bali.
                </p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-12">
                {{-- Kartu Transfer Bank --}}
                <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-white/10 bg-[#101010] p-7 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-accent/40 hover:shadow-[0_24px_60px_-18px_rgba(138,0,194,0.45)] lg:col-span-6 sm:p-9" data-reveal>
                    <div aria-hidden="true" class="pointer-events-none absolute -top-20 -right-20 h-64 w-64 rounded-full bg-accent/15 blur-3xl transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold text-accent-soft">
                                Transfer Bank
                            </span>
                            <span class="text-xs font-medium text-white/50">Rekening Resmi Gereja</span>
                        </div>

                        <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold tracking-wider text-white">{{ $donation['bank_name'] }}</span>
                                <span class="text-xs text-white/50">{{ $donation['bank_branch'] }}</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="font-mono text-2xl font-bold tracking-wider text-white shimmer-sweep">{{ $donation['account_number'] }}</span>
                                <button
                                    type="button"
                                    @click="copyAccount('{{ $donation['account_number_raw'] }}')"
                                    class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-xs font-medium text-white transition-all hover:border-accent hover:text-accent-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft"
                                >
                                    <svg x-show="!copiedBca" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                    </svg>
                                    <svg x-show="copiedBca" x-cloak class="h-3.5 w-3.5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                    </svg>
                                    <span x-text="copiedBca ? 'Tersalin!' : 'Salin Rekening'">Salin Rekening</span>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-white/50">Atas Nama: <strong class="text-white">{{ $donation['account_name'] }}</strong></p>
                        </div>

                        <div class="mt-6 space-y-2.5 text-xs text-white/60">
                            <p class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent-soft"></span>
                                <span>Persembahan Persepuluhan, Kolekte Mingguan, dan Syukur</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent-soft"></span>
                                <span>Donasi Bakti Sosial Kasih bagi sesama di Bali</span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-white/10 pt-5">
                        <a
                            href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappConfirmMessage }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-accent to-accent-strong px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:shadow-[0_8px_28px_-8px_rgba(138,0,194,0.7)] focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft focus-visible:ring-offset-2 focus-visible:ring-offset-[#101010]"
                        >
                            <span>Konfirmasi Bukti Transfer via WhatsApp</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                {{-- Kartu QRIS Digital --}}
                <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-white/10 bg-[#101010] p-7 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-accent/40 hover:shadow-[0_24px_60px_-18px_rgba(138,0,194,0.45)] lg:col-span-6 sm:p-9" data-reveal style="transition-delay:80ms">
                    <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-accent/15 blur-3xl transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold text-accent-soft">
                                QRIS Standar Nasional
                            </span>
                            <span class="text-xs font-medium text-white/50">Semua Bank & e-Wallet</span>
                        </div>

                        <div class="mt-6 grid items-center gap-6 sm:grid-cols-12">
                            <div class="flex flex-col items-center justify-center rounded-2xl bg-white p-4 shadow-lg sm:col-span-5">
                                <div class="grid aspect-square w-36 place-items-center rounded-xl bg-[#121212] p-2 text-white qr-glow">
                                    <svg viewBox="0 0 100 100" class="h-full w-full fill-white" aria-label="QRIS Code GKKD Denpasar">
                                        <rect x="5" y="5" width="28" height="28" fill="white" />
                                        <rect x="9" y="9" width="20" height="20" fill="#121212" />
                                        <rect x="13" y="13" width="12" height="12" fill="white" />
                                        
                                        <rect x="67" y="5" width="28" height="28" fill="white" />
                                        <rect x="71" y="9" width="20" height="20" fill="#121212" />
                                        <rect x="75" y="13" width="12" height="12" fill="white" />
                                        
                                        <rect x="5" y="67" width="28" height="28" fill="white" />
                                        <rect x="9" y="71" width="20" height="20" fill="#121212" />
                                        <rect x="13" y="75" width="12" height="12" fill="white" />
                                        
                                        <rect x="38" y="10" width="8" height="8" fill="white" />
                                        <rect x="50" y="10" width="8" height="8" fill="white" />
                                        <rect x="38" y="24" width="8" height="8" fill="white" />
                                        <rect x="50" y="24" width="8" height="8" fill="white" />
                                        <rect x="10" y="42" width="8" height="8" fill="white" />
                                        <rect x="24" y="42" width="8" height="8" fill="white" />
                                        <rect x="38" y="38" width="24" height="24" fill="white" />
                                        <rect x="42" y="42" width="16" height="16" fill="#8a00c2" />
                                        <rect x="46" y="46" width="8" height="8" fill="white" />
                                        <rect x="68" y="42" width="8" height="8" fill="white" />
                                        <rect x="82" y="42" width="8" height="8" fill="white" />
                                        <rect x="38" y="68" width="8" height="8" fill="white" />
                                        <rect x="50" y="68" width="8" height="8" fill="white" />
                                        <rect x="68" y="68" width="8" height="8" fill="white" />
                                        <rect x="82" y="68" width="8" height="8" fill="white" />
                                        <rect x="38" y="82" width="8" height="8" fill="white" />
                                        <rect x="50" y="82" width="8" height="8" fill="white" />
                                        <rect x="68" y="82" width="8" height="8" fill="white" />
                                        <rect x="82" y="82" width="8" height="8" fill="white" />
                                    </svg>
                                </div>
                                <span class="mt-3 text-center text-[10px] font-bold tracking-widest text-slate-800 uppercase">{{ $donation['qris_merchant'] }}</span>
                            </div>

                            <div class="space-y-3 sm:col-span-7">
                                <h4 class="text-sm font-semibold text-white">Bebas Biaya Antarbank</h4>
                                <p class="text-xs leading-relaxed text-white/60">
                                    Pindai (scan) kode QRIS di samping menggunakan aplikasi perbankan apa pun (BCA, Mandiri, BRI, BNI) atau dompet digital (GoPay, OVO, Dana, ShopeePay).
                                </p>
                                <div class="rounded-xl border border-white/10 bg-white/5 p-3 text-[11px] text-white/60">
                                    <strong class="font-semibold text-white">NMID:</strong> {{ $donation['qris_nmid'] }}<br>
                                    <strong class="font-semibold text-white">Nama Merchant:</strong> {{ $donation['qris_merchant'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-white/10 pt-5">
                        <p class="text-center text-xs text-white/50">
                            <em>{{ $donation['verse'] }}</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Evaluasi Khotbah Bulanan --}}
    <section class="relative overflow-hidden border-t border-line pt-16 pb-10 lg:pt-24 lg:pb-14">
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-accent/10 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-14">
                <div class="lg:col-span-7" data-reveal>
                    <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3.5 py-1 text-xs font-medium text-muted">
                        <span class="h-2 w-2 rounded-full bg-accent animate-pulse" aria-hidden="true"></span>
                        Evaluasi Bulanan
                    </span>
                    <h2 class="mt-5 font-display text-4xl leading-[1.15] font-normal tracking-tight text-ink sm:text-5xl">
                        Suara Anda Membentuk Mimbar Kami
                    </h2>
                    <p class="mt-4 max-w-[52ch] text-base leading-relaxed text-muted">
                        Setiap bulan kami membuka kesempatan menilai khotbah yang sudah disampaikan.
                        Satu kali dalam sebulan, ±3 menit — dan jawaban Anda membantu tim mimbar bertumbuh.
                    </p>
                    <ul class="mt-6 space-y-3 text-sm text-muted">
                        <li class="flex items-start gap-2.5">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-accent"></span>
                            <span>Menilai relevansi & cara penyampaian firman.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-accent"></span>
                            <span>Anonim, privat, dan hanya satu kali per bulan.</span>
                        </li>
                    </ul>
                    <div class="mt-9 flex flex-wrap items-center gap-4">
                        <a
                            href="{{ route('evaluasi-khotbah') }}"
                            class="inline-flex min-h-11 items-center justify-center rounded-full bg-accent px-7 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            Isi Evaluasi Bulan Ini &rarr;
                        </a>
                        <span class="text-xs text-muted">Satu kali per bulan · ±3 menit</span>
                    </div>
                </div>

                <div class="lg:col-span-5" data-reveal style="transition-delay:80ms">
                    <div class="group relative overflow-hidden rounded-3xl border border-line bg-surface p-8 shadow-sm transition-all hover:border-accent/40 hover:shadow-md">
                        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-accent/0 via-accent to-accent/0 transition-opacity opacity-60 group-hover:opacity-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                Periode Evaluasi
                            </span>
                            <span class="text-xs text-muted">Bulan {{ now()->translatedFormat('F Y') }}</span>
                        </div>
                        <div class="mt-6 flex items-center gap-5">
                            <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-accent/10 text-accent dark:text-accent-soft">
                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-ink">Dibuka tiap bulan</h3>
                                <p class="mt-1 text-sm leading-relaxed text-muted">Bukan harian — satu evaluasi penuh per bulan.</p>
                            </div>
                        </div>
                        <div class="mt-6 border-t border-line pt-5">
                            <div class="flex items-center justify-between text-xs text-muted">
                                <span>Skala penilaian</span>
                                <span>1 — 5</span>
                            </div>
                            <div class="mt-3 flex items-center gap-1.5" aria-hidden="true">
                                @foreach (range(1, 5) as $n)
                                    <span class="h-2 flex-1 rounded-full bg-line transition-colors group-hover:bg-accent/40"></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
