<x-fe.layout.app
    title="Pelayanan — GKKD Denpasar"
    description="Ragam pelayanan dan tim pelayanan di GKKD Denpasar: musik, multimedia, diakonia, doa, dan sekolah minggu."
>
    @php
        $teams = [
            [
                'slug' => 'musik',
                'badge' => 'Tim Musisi',
                'name' => 'Pelayanan Musik & Pujian',
                'headline' => 'Memimpin masuk ke hadirat Tuhan',
                'desc' => 'Memenuhi ruang ibadah dengan pujian dan penyembahan yang dipersiapkan dengan hati.',
                'image' => asset('images/church-sanctuary.jpg'),
                'alt' => 'Ruang ibadah GKKD Denpasar',
            ],
            [
                'slug' => 'multimedia',
                'badge' => 'Tim Multimedia',
                'name' => 'Multimedia & Tata Ibadah',
                'headline' => 'Di balik layar ibadah',
                'desc' => 'Tata suara, lighting, livestreaming, dan dokumentasi untuk setiap pelayanan.',
                'image' => 'https://images.unsplash.com/photo-1748698535024-e246f0da88dc?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                'alt' => 'Operator mengoperasikan panel kontrol suara',
                'href' => route('kegiatan.pelayanan.multimedia'),
            ],
            [
                'slug' => 'diakonia',
                'badge' => 'Tim Diakonia',
                'name' => 'Diakonia & Aksi Kasih',
                'headline' => 'Kasih yang bergerak nyata',
                'desc' => 'Bakti sosial, kunjungan, dan aksi kasih bagi jemaat dan masyarakat sekitar.',
                'image' => asset('images/outreach.jpg'),
                'alt' => 'Kegiatan bakti sosial dan donor darah GKKD Denpasar',
            ],
            [
                'slug' => 'doa',
                'badge' => 'Tim Doa',
                'name' => 'Tim Doa & Konseling',
                'headline' => 'Mendampingi dalam doa dan duka',
                'desc' => 'Doa syafaat dan pendampingan konseling bagi jemaat dan para pelayan.',
                'image' => 'https://images.unsplash.com/photo-1611067138996-f3f8906ef13e?ixlib=rb-4.0.3&w=1200&q=80&auto=format&fit=crop',
                'alt' => 'Lilin menyala di dalam gereja',
            ],
            [
                'slug' => 'anak',
                'badge' => 'Tim Guru Anak',
                'name' => 'Pelayanan Anak',
                'headline' => 'Menabur iman sejak kecil',
                'desc' => 'Sekolah Minggu yang menumbuhkan iman anak dalam sukacita dan kasih.',
                'image' => asset('images/sunday-school.jpg'),
                'alt' => 'Kegiatan Sekolah Minggu GKKD Denpasar',
            ],
            [
                'slug' => 'pemuda',
                'badge' => 'Tim Pemuda',
                'name' => 'Pelayanan Generasi Muda',
                'headline' => 'Generasi muda, agen perubahan',
                'desc' => 'Persekutuan dan pembinaan generasi muda GKKD Denpasar.',
                'image' => asset('images/fellowship.jpg'),
                'alt' => 'Persekutuan pemuda dan mahasiswa GKKD Denpasar',
            ],
        ];

        $teams = array_map(fn ($t) => $t + ['href' => route('kegiatan.pelayanan.show', $t['slug'])], $teams);
    @endphp

    {{-- Hero — coverflow 3D, tema gelap netral --}}
    <section
        x-data="{
            active: 0,
            playing: !window.matchMedia('(prefers-reduced-motion: reduce)').matches,
            paused: false,
            progress: 0,
            speed: 6000,
            tickMs: 30,
            vw: window.innerWidth,
            items: @js($teams),

            tick() {
                if (!this.playing || this.paused || document.hidden) return;
                this.progress += (this.tickMs / this.speed) * 100;
                if (this.progress >= 100) this.next();
            },
            offset(i) {
                const n = this.items.length;
                let off = i - this.active;
                const half = Math.floor(n / 2);
                if (off > half) off -= n;
                if (off < -half) off += n;
                return off;
            },
            cardStyle(i) {
                const off = this.offset(i);
                const abs = Math.abs(off);
                const hidden = abs > 2;
                let spacing = 140, depth = 110;
                if (this.vw >= 768) { spacing = 230; depth = 160; }
                if (this.vw >= 1280) { spacing = 265; depth = 180; }
                return 'transform:translate(-50%,-50%) translateX(' + (off * spacing) + 'px) translateZ(' + (-abs * depth) + 'px) rotateY(' + (off * -32) + 'deg) scale(' + (1 - abs * 0.05) + ');z-index:' + (30 - abs) + ';opacity:' + (hidden ? 0 : 1) + ';filter:brightness(' + (1 - abs * 0.12) + ');pointer-events:' + (hidden ? 'none' : 'auto');
            },
            go(i) {
                this.active = (i + this.items.length) % this.items.length;
                this.progress = 0;
            },
            next() { this.go(this.active + 1); },
            prev() { this.go(this.active - 1); },
            start() {
                setInterval(() => this.tick(), this.tickMs);
            },
        }"
        x-init="start()"
        @resize.window="vw = window.innerWidth"
        @keydown.window.arrow-right="next()"
        @keydown.window.arrow-left="prev()"
        class="relative -mt-[var(--nav-h)] flex min-h-[100svh] select-none flex-col items-center justify-center overflow-hidden bg-[#0b0a08] pt-[var(--nav-h)]"
        role="region"
        aria-roledescription="carousel"
        aria-label="Daftar tim pelayanan"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
    >
        {{-- Background blur dari slide aktif --}}
        <template x-for="(s, i) in items" :key="'bg' + s.slug">
            <div class="absolute inset-0 transition-opacity duration-700" :class="active === i ? 'opacity-100' : 'opacity-0'">
                <img :src="s.image" alt="" class="h-full w-full scale-110 object-cover opacity-30 blur-2xl">
            </div>
        </template>
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0b0a08]/80 via-transparent to-[#0b0a08]"></div>

        {{-- Carousel 3D --}}
        <div class="relative z-10 h-[420px] w-full max-w-4xl md:h-[540px] lg:h-[600px]" style="perspective:1600px">
            {{-- Panah kiri / kanan --}}
            <button
                type="button"
                @click="prev()"
                aria-label="Tim sebelumnya"
                class="absolute left-1 top-1/2 z-40 -translate-y-1/2 p-2 text-white/60 transition hover:scale-110 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent lg:-left-12"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button
                type="button"
                @click="next()"
                aria-label="Tim berikutnya"
                class="absolute right-1 top-1/2 z-40 -translate-y-1/2 p-2 text-white/60 transition hover:scale-110 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent lg:-right-12"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <template x-for="(s, i) in items" :key="'card' + s.slug">
                <a
                    :href="s.href"
                    @click="i !== active ? ($event.preventDefault(), go(i)) : null"
                    :aria-hidden="Math.abs(offset(i)) > 2 ? 'true' : 'false'"
                    class="absolute left-1/2 top-1/2 block h-72 w-44 cursor-pointer overflow-hidden rounded-md ring-1 ring-white/10 transition-all duration-700 motion-reduce:transition-none [transition-timing-function:cubic-bezier(.22,.61,.36,1)] will-change-transform focus:outline-none focus-visible:ring-2 focus-visible:ring-accent md:h-[30rem] md:w-72 md:rounded-lg lg:h-[34rem] lg:w-80"
                    :style="cardStyle(i)"
                >
                    <img :src="s.image" :alt="s.alt" class="h-full w-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/25"></div>

                    <span
                        class="absolute left-1/2 top-3 -translate-x-1/2 whitespace-nowrap border border-white/70 px-2 py-1 text-[8px] font-semibold uppercase tracking-[0.2em] text-white/90 transition-opacity duration-500 md:top-4 md:px-3 md:py-1.5 md:text-[10px]"
                        :class="active === i ? 'opacity-100' : 'opacity-0'"
                        x-text="s.badge"
                    ></span>

                    <span
                        class="absolute bottom-3 left-1/2 flex -translate-x-1/2 items-center gap-1.5 whitespace-nowrap rounded-full bg-accent px-3 py-1.5 text-[9px] font-extrabold uppercase tracking-[0.18em] text-white shadow-lg shadow-accent/40 transition-all duration-500 hover:bg-accent-strong md:bottom-5 md:px-5 md:py-2.5 md:text-[10px]"
                        :class="active === i ? 'pointer-events-auto opacity-100' : 'pointer-events-none opacity-0'"
                    >
                        Lihat Profil Tim
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12" />
                        </svg>
                    </span>
                </a>
            </template>

            {{-- Copywriting per slide: tagline → nama tim → deskripsi --}}
            <div class="pointer-events-none absolute inset-0 z-30 flex items-center justify-center">
                <template x-for="(s, i) in items" :key="'t' + s.slug">
                    <div
                        class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center transition-all duration-500"
                        :class="active === i ? 'translate-y-0 opacity-100' : 'translate-y-3 opacity-0'"
                    >
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.35em] text-accent-soft md:text-xs" x-text="s.headline"></p>
                        <h1 class="mt-3 max-w-3xl text-3xl font-extrabold uppercase leading-tight tracking-[0.08em] text-white [text-shadow:0_4px_24px_rgba(0,0,0,.75)] md:text-6xl lg:text-7xl" x-text="s.name"></h1>
                        <p class="mt-4 max-w-md text-xs leading-relaxed text-white/75 [text-shadow:0_2px_12px_rgba(0,0,0,.8)] md:max-w-xl md:text-sm" x-text="s.desc"></p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Kontrol: dot pagination + play/pause --}}
        <div class="z-40 mt-8 flex items-center justify-center gap-4">
            <div class="flex items-center gap-2.5">
                <template x-for="(s, i) in items" :key="'d' + s.slug">
                    <button
                        type="button"
                        @click="go(i)"
                        :aria-label="'Ke ' + s.name"
                        :aria-current="i === active ? 'true' : 'false'"
                        class="relative rounded-full bg-white/25 p-2 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                    >
                        <span class="block overflow-hidden rounded-full" :class="i === active ? 'h-2 w-10' : 'h-2 w-2'">
                            <span
                                class="block h-full rounded-full bg-accent transition-[width] duration-75 ease-linear"
                                :style="'width:' + (i === active ? progress : 0) + '%'"
                            ></span>
                        </span>
                    </button>
                </template>
            </div>

            <button
                type="button"
                @click="playing = !playing"
                :aria-label="playing ? 'Jeda autoplay' : 'Jalankan autoplay'"
                class="rounded-full border border-white/20 p-2 text-white/70 transition hover:border-white/60 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
            >
                <svg x-show="playing" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 5h4v14H6zM14 5h4v14h-4z" /></svg>
                <svg x-show="!playing" x-cloak class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z" /></svg>
            </button>
        </div>
    </section>

</x-fe.layout.app>
