@php
    // TODO: ganti dengan nomor WhatsApp gereja (format internasional tanpa "+").
    $whatsappNumber = '6281234567890';
    $whatsappMessage = rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.');

    // Kegiatan & pertemuan jemaat.
    $schedules = [
        [
            'title' => 'Pelayanan',
            'time' => 'Bersamaan dengan Ibadah',
            'day' => 'Minggu',
            'badge' => 'Tim Pelayanan',
            'desc' => 'Ragam tim pelayanan gereja: musik, multimedia, diakonia, doa, anak, dan generasi muda.',
            'link' => route('kegiatan.pelayanan'),
        ],
        [
            'title' => 'Komsel',
            'time' => 'Pukul 19.30 WITA',
            'day' => 'Kamis / Jumat',
            'badge' => 'Komunitas Sel',
            'desc' => 'Kelompok kecil di rumah-rumah jemaat di Renon, Sanur, Denpasar Barat, dan Badung untuk saling peduli.',
            'link' => route('kegiatan.komsel'),
        ],
        [
            'title' => 'Retret / Camp',
            'time' => 'Tahunan',
            'day' => 'Sep / Des',
            'badge' => 'Keluarga & Pemuda',
            'desc' => 'Retret keluarga, camp pemuda, dan camp anak tahunan untuk pembaharuan iman dan relasi.',
            'link' => route('kegiatan.retret-camp'),
        ],
    ];

    // Ringkasan pengumuman terbaru gereja.
    $announcements = [
        [
            'date' => '28 Sep 2026',
            'tag' => 'Sakramen',
            'title' => 'Pendaftaran Baptisan Kudus & Penyerahan Anak',
            'summary' => 'Bagi jemaat yang rindu menerima baptisan selam atau menyerahkan anak, kelas pembekalan dibuka mulai Minggu depan.',
            'badge_color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
        ],
        [
            'date' => '26 Sep 2026',
            'tag' => 'Pelayanan',
            'title' => 'Pertemuan Tim Multimedia & Pelayan Musik',
            'summary' => 'Workshop audio-visual dan pengenalan alur ibadah baru bersama seluruh tim pelayan hari Sabtu pukul 16.00 WITA.',
            'badge_color' => 'bg-accent/10 text-accent dark:text-accent-soft',
        ],
        [
            'date' => '04 Okt 2026',
            'tag' => 'Aksi Kasih',
            'title' => 'Bakti Sosial & Donor Darah Kasih',
            'summary' => 'Bekerja sama dengan PMI Kota Denpasar bertempat di aula serbaguna gereja. Terbuka bagi jemaat dan masyarakat umum.',
            'badge_color' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
        ],
        [
            'date' => '11 Okt 2026',
            'tag' => 'Komunitas',
            'title' => 'Retreat Pemuda & Profesional Muda 2026',
            'summary' => 'Pendaftaran awal dibuka untuk retreat tahunan di Bedugul dengan tema "Berakar dan Berbuah di Era Digital".',
            'badge_color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
        ],
    ];

    // Ringkasan berita terkini.
    $latestNews = [
        [
            'title' => 'Menghadirkan Damai Kristus di Tengah Dinamika Kota Denpasar',
            'date' => '20 September 2026',
            'category' => 'Khotbah & Renungan',
            'image' => asset('images/church-sanctuary.jpg'),
            'summary' => 'Refleksi mendalam mengenai panggilan jemaat untuk hidup sebagai pembawa damai dan teladan di tempat kerja.',
            'read_time' => '4 Menit Baca',
            'link' => route('berita'),
        ],
        [
            'title' => 'Laporan Aksi Kasih: Penyaluran Paket Sembako & Perlengkapan Belajar',
            'date' => '15 September 2026',
            'category' => 'Bakti Sosial',
            'image' => asset('images/outreach.jpg'),
            'summary' => 'Sebanyak 120 paket perlengkapan sekolah dan kebutuhan pokok telah disalurkan bagi keluarga prasejahtera di Denpasar.',
            'read_time' => '3 Menit Baca',
            'link' => route('berita'),
        ],
        [
            'title' => 'Keceriaan Anak-Anak di Kelas Karakter Sekolah Minggu',
            'date' => '10 September 2026',
            'category' => 'Sekolah Minggu',
            'image' => asset('images/sunday-school.jpg'),
            'summary' => 'Mengenalkan benih firman Tuhan sejak dini melalui metode mendongeng, kreativitas tangan, dan lagu gerak tari.',
            'read_time' => '3 Menit Baca',
            'link' => route('berita'),
        ],
    ];

    // Banner dinamis untuk hero slider.
    $heroBanners = [
        [
            'image' => asset('images/church-sanctuary.jpg'),
            'alt' => 'Ruang Ibadah GKKD Denpasar',
            'badge' => 'Sanctuary GKKD Denpasar',
            'caption' => 'Suasana ibadah hangat, intim, dan bersahabat',
        ],
        [
            'image' => asset('images/fellowship.jpg'),
            'alt' => 'Komunitas & Persekutuan Jemaat GKKD Denpasar',
            'badge' => 'Komunitas Kasih',
            'caption' => 'Bertumbuh bersama dalam doa dan keakraban keluarga',
        ],
        [
            'image' => asset('images/sunday-school.jpg'),
            'alt' => 'Kelas Anak Sekolah Minggu GKKD Denpasar',
            'badge' => 'Sekolah Minggu Ceria',
            'caption' => 'Pendidikan karakter Alkitab yang interaktif dan ramah anak',
        ],
        [
            'image' => asset('images/outreach.jpg'),
            'alt' => 'Aksi Kasih Pelayanan Masyarakat Bali',
            'badge' => 'Aksi Kasih di Bali',
            'caption' => 'Melayani sesama dengan kepedulian yang tulus',
        ],
    ];

    $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
@endphp

<x-fe.layout.app
    title="GKKD Denpasar — Gereja Kristen Kemuliaan Allah"
    description="GKKD Denpasar adalah keluarga rohani yang bertumbuh dalam iman dan melayani kota Denpasar, Bali."
>
    {{-- Hero --}}
    <section class="relative overflow-hidden pt-8 pb-16 lg:pt-14 lg:pb-24">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:gap-12 lg:px-8">
            {{-- Kolom Teks: Tetap / Statis --}}
            <div class="lg:col-span-6">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3.5 py-1 text-xs font-medium text-muted">
                    <span class="h-2 w-2 rounded-full bg-accent animate-pulse" aria-hidden="true"></span>
                    Ibadah Tatap Muka & Online
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Gereja Kristen Kemah Daud (GKKD) Denpasar
                </h1>
                <p class="mt-5 max-w-[56ch] text-base leading-relaxed text-muted sm:text-lg">
                    Rumah untuk bertumbuh dalam iman dan kasih. Keluarga rohani yang rindu menghadirkan hadirat Tuhan dan melayani sesama dengan ketulusan di Denpasar, Bali.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a
                        href="#jadwal"
                        class="inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
                    >
                        Jadwal Ibadah
                    </a>
                    <a
                        href="{{ route('tentang') }}"
                        class="inline-flex items-center justify-center rounded-full border border-line px-6 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft {{ $focusRing }}"
                    >
                        Tentang Kami
                    </a>
                </div>
            </div>

            {{-- Kolom Banner Slider: Gambar Dinamis, Auto Slide, Swipe, & Tombol Kiri Kanan --}}
            <div class="lg:col-span-6">
                <div
                    x-data="{
                        current: 0,
                        total: {{ count($heroBanners) }},
                        autoplayTimer: null,
                        touchStartX: 0,
                        touchEndX: 0,
                        init() {
                            this.startAutoplay();
                        },
                        startAutoplay() {
                            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                            this.stopAutoplay();
                            this.autoplayTimer = setInterval(() => {
                                this.next();
                            }, 5000);
                        },
                        stopAutoplay() {
                            if (this.autoplayTimer) {
                                clearInterval(this.autoplayTimer);
                                this.autoplayTimer = null;
                            }
                        },
                        next() {
                            this.current = (this.current + 1) % this.total;
                        },
                        prev() {
                            this.current = (this.current - 1 + this.total) % this.total;
                        },
                        goTo(index) {
                            this.current = index;
                            this.startAutoplay();
                        },
                        handleTouchStart(e) {
                            this.touchStartX = e.touches[0].clientX;
                            this.stopAutoplay();
                        },
                        handleTouchEnd(e) {
                            this.touchEndX = e.changedTouches[0].clientX;
                            const diff = this.touchStartX - this.touchEndX;
                            if (Math.abs(diff) > 40) {
                                if (diff > 0) {
                                    this.next();
                                } else {
                                    this.prev();
                                }
                            }
                            this.startAutoplay();
                        }
                    }"
                    @mouseenter="stopAutoplay()"
                    @mouseleave="startAutoplay()"
                    @keydown.left="prev()"
                    @keydown.right="next()"
                    tabindex="0"
                    role="region"
                    aria-roledescription="carousel"
                    aria-label="Banner Galeri Kegiatan GKKD Denpasar"
                    class="group relative aspect-16/10 overflow-hidden rounded-2xl border border-line bg-ink/5 shadow-lg select-none lg:aspect-4/3 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                    @touchstart.passive="handleTouchStart($event)"
                    @touchend.passive="handleTouchEnd($event)"
                >
                    {{-- Slide Items --}}
                    @foreach ($heroBanners as $index => $banner)
                        <div
                            x-show="current === {{ $index }}"
                            x-transition:enter="transition-opacity ease-out duration-500"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition-opacity ease-in duration-300 absolute inset-0"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute inset-0 h-full w-full"
                            role="group"
                            aria-roledescription="slide"
                            aria-label="Slide {{ $index + 1 }} dari {{ count($heroBanners) }}"
                        >
                            <img
                                src="{{ $banner['image'] }}"
                                alt="{{ $banner['alt'] }}"
                                width="800"
                                height="600"
                                class="h-full w-full object-cover"
                                @if ($index === 0) fetchpriority="high" @else loading="lazy" @endif
                            >
                            <div class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent p-5 sm:p-6 text-white">
                                <span class="inline-block rounded-full bg-accent/80 px-2.5 py-0.5 text-[11px] font-semibold tracking-wider uppercase text-white backdrop-blur-sm">
                                    {{ $banner['badge'] }}
                                </span>
                                <p class="mt-1.5 text-sm font-semibold text-white/95 sm:text-base">
                                    {{ $banner['caption'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    {{-- Tombol Navigasi Kiri (Prev) --}}
                    <button
                        type="button"
                        @click="prev()"
                        aria-label="Banner sebelumnya"
                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/40 text-white backdrop-blur-md border border-white/20 transition-all hover:bg-black/70 hover:scale-105 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-white opacity-80 group-hover:opacity-100"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    {{-- Tombol Navigasi Kanan (Next) --}}
                    <button
                        type="button"
                        @click="next()"
                        aria-label="Banner berikutnya"
                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/40 text-white backdrop-blur-md border border-white/20 transition-all hover:bg-black/70 hover:scale-105 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-white opacity-80 group-hover:opacity-100"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>

                    {{-- Indikator Dots / Pills --}}
                    <div class="absolute bottom-4 right-4 z-20 flex items-center gap-1.5 rounded-full bg-black/50 backdrop-blur-md px-3 py-1.5 border border-white/15">
                        @foreach ($heroBanners as $idx => $b)
                            <button
                                type="button"
                                @click="goTo({{ $idx }})"
                                :aria-current="current === {{ $idx }} ? 'true' : 'false'"
                                aria-label="Ke slide {{ $idx + 1 }}"
                                class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                                :class="current === {{ $idx }} ? 'w-6 bg-accent' : 'w-2 bg-white/50 hover:bg-white/80'"
                            ></button>
                        @endforeach
                    </div>

                    {{-- Counter Slide --}}
                    <div class="absolute top-4 right-4 z-20 rounded-full bg-black/50 backdrop-blur-md px-3 py-1 text-xs font-medium text-white/90 border border-white/15">
                        <span x-text="current + 1"></span> / <span>{{ count($heroBanners) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sambutan + Jadwal Ibadah --}}
    <section id="jadwal" class="border-t border-line bg-ink/5 py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Jadwal Pertemuan & Ibadah
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Setiap orang diterima apa adanya. Anda dan keluarga diundang untuk bersekutu bersama kami di Denpasar.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (array_slice($schedules, 0, 3) as $schedule)
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                    {{ $schedule['badge'] }}
                                </span>
                                <span class="text-xs text-muted">WITA</span>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-ink">{{ $schedule['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                {{ $schedule['desc'] }}
                            </p>
                        </div>
                        <div class="mt-6 border-t border-line pt-4">
                            <p class="text-base font-semibold text-ink">{{ $schedule['time'] }}</p>
                            <a href="{{ $schedule['link'] }}" class="mt-2 inline-flex items-center text-xs font-semibold text-accent hover:underline dark:text-accent-soft">
                                Detail kegiatan &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 1 Tombol: Lihat Jadwal Pertemuan & Ibadah Lainnya --}}
            <div class="mt-12 text-center">
                <a
                    href="{{ route('kegiatan.index') }}"
                    class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}"
                >
                    Lihat Jadwal Pertemuan & Ibadah Lainnya &rarr;
                </a>
            </div>
        </div>
    </section>

    {{-- Rangkuman Khotbah (Layout Card Besar: Foto Kiri, Informasi Kanan) --}}
    <section class="border-t border-line py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                        Pesan Mimbar Terbaru
                    </span>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                        Rangkuman Khotbah
                    </h2>
                    <p class="mt-2 text-base leading-relaxed text-muted">
                        Pokok-pokok firman Tuhan yang telah disampaikan dalam ibadah jemaat GKKD Denpasar.
                    </p>
                </div>
            </div>

            {{-- Daftar Khotbah (Kartu Besar: Foto Kiri, Info Kanan) --}}
            <div class="mt-10 space-y-8">

                {{-- ── Kartu 1 (Khotbah Utama) ── --}}
                <div class="group flex flex-col overflow-hidden rounded-3xl border border-line bg-surface shadow-sm transition-all hover:border-accent/40 hover:shadow-md lg:flex-row">
                    {{-- Foto Pendeta / Cover (Kiri) --}}
                    <div class="relative h-64 w-full shrink-0 overflow-hidden bg-ink/5 sm:h-72 lg:h-auto lg:w-80 xl:w-96">
                        <img
                            src="https://picsum.photos/seed/pastor-samuel/600/600"
                            alt="Foto Pdt. Samuel Wijaya"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <div class="absolute top-4 left-4">
                            <span class="rounded-full bg-accent/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white backdrop-blur-xs">
                                Utama minggu ini
                            </span>
                        </div>
                    </div>

                    {{-- Informasi Khotbah (Kanan) --}}
                    <div class="flex flex-1 flex-col justify-between p-6 sm:p-8 lg:p-10">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                    Ibadah Raya Minggu Pagi
                                </span>
                                <span class="text-xs text-muted">Minggu, 21 September 2025 &bull; 09.00 WITA</span>
                            </div>

                            <h3 class="mt-3 text-2xl font-bold leading-tight text-ink sm:text-3xl">
                                Hidup dalam Kasih Karunia yang Cukup
                            </h3>

                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm font-medium text-ink">
                                <span>Pdt. Samuel Wijaya</span>
                                <span class="text-line" aria-hidden="true">&bull;</span>
                                <span class="inline-flex items-center gap-1.5 text-accent dark:text-accent-soft font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4 shrink-0" aria-hidden="true">
                                        <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687ZM7.5 14.055c-.935-.531-2.12-.603-3.213-.492-1.18.117-2.37.46-3.287.81V3.58c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v10.523ZM7.5 1.75a.75.75 0 0 1 1.5 0 .75.75 0 0 1-1.5 0Z"/>
                                    </svg>
                                    2 Korintus 12:7&ndash;10
                                </span>
                            </div>

                            <p class="mt-4 text-base leading-relaxed text-muted">
                                Paulus mengajarkan bahwa kelemahan bukan penghalang, melainkan ruang di mana kuasa Kristus dinyatakan dengan nyata. Kasih karunia Tuhan selalu cukup untuk menanggung setiap beban kehidupan kita sehari-hari.
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line pt-6">
                            <a
                                href="{{ route('kegiatan.khotbah.show', 'hidup-dalam-kasih-karunia-yang-cukup') }}"
                                class="inline-flex items-center gap-2 rounded-full bg-accent px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-accent-strong"
                            >
                                <span>Lihat Detail Khotbah</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a
                                href="#"
                                download
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-5 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                    <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                </svg>
                                Unduh Slide PPT
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Tombol Lihat Semua Rangkuman Khotbah Lainnya --}}
            <div class="mt-12 text-center">
                <a
                    href="{{ route('kegiatan.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-line bg-surface px-8 py-4 text-base font-semibold text-ink transition-all hover:border-accent hover:text-accent dark:hover:text-accent-soft shadow-xs"
                >
                    Lihat Rangkuman Khotbah Lainnya &rarr;
                </a>
            </div>
        </div>
    </section>

    {{-- Ringkasan Berita --}}
    <section class="border-t border-line py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                        Kabar & Berita Terkini
                    </h2>
                    <p class="mt-3 text-base leading-relaxed text-muted">
                        Dokumentasi liputan pelayanan, renungan firman, dan kabar sukacita jemaat GKKD Denpasar.
                    </p>
                </div>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestNews as $news)
                    <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                        <div>
                            <div class="aspect-16/10 overflow-hidden bg-ink/5">
                                <img
                                    src="{{ $news['image'] }}"
                                    alt="{{ $news['title'] }}"
                                    width="500"
                                    height="312"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                >
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-xs text-muted">
                                    <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">
                                        {{ $news['category'] }}
                                    </span>
                                    <span>{{ $news['date'] }}</span>
                                </div>
                                <h3 class="mt-3 text-lg font-semibold leading-snug text-ink">
                                    <a href="{{ $news['link'] }}" class="hover:text-accent dark:hover:text-accent-soft">
                                        {{ $news['title'] }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm leading-relaxed text-muted">
                                    {{ $news['summary'] }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-line px-6 py-4 text-xs">
                            <span class="text-muted">{{ $news['read_time'] }}</span>
                            <a href="{{ $news['link'] }}" class="font-semibold text-accent hover:underline dark:text-accent-soft">
                                Baca selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- 1 Tombol: Lihat Berita Lainnya --}}
            <div class="mt-12 text-center">
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
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Pengumuman & Warta Terbaru
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Agenda penting jemaat, pendaftaran sakramen, dan informasi pelayanan terkini.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (array_slice($announcements, 0, 3) as $item)
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-sm">
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
            <div class="mt-12 text-center">
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
    <section class="border-t border-line py-16 lg:py-20" x-data="{
        initFullCalendar() {
            if (typeof FullCalendar !== 'undefined' && this.$refs.calendarEl) {
                const calendar = new FullCalendar.Calendar(this.$refs.calendarEl, {
                    initialView: 'dayGridMonth',
                    initialDate: '2026-10-01',
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next today'
                    },
                    events: [
                        { id: '1', title: 'Bakti Sosial & Donor Darah', start: '2026-10-04', color: '#e11d48' },
                        { id: '2', title: 'Retreat Pemuda Bedugul', start: '2026-10-11', end: '2026-10-14', color: '#2563eb' },
                        { id: '3', title: 'Lokakarya Musik & Multimedia', start: '2026-10-18', color: '#8a00c2' },
                        { id: '4', title: 'Baptisan Kudus & Penyerahan Anak', start: '2026-10-25', color: '#059669' }
                    ],
                    height: 'auto'
                });
                calendar.render();
            }
        }
    }" x-init="setTimeout(() => initFullCalendar(), 100)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
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
                <div class="rounded-3xl border border-line bg-surface p-6 shadow-sm lg:col-span-7">
                    <div x-ref="calendarEl" class="fc-theme-tailwind text-sm"></div>
                </div>

                {{-- Kanan (5 Columns): Daftar Event Bulan Ini --}}
                <div class="space-y-4 lg:col-span-5">
                    <div class="flex items-center justify-between border-b border-line pb-3">
                        <h3 class="text-base font-bold text-ink">Daftar Event Bulan Ini</h3>
                        <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs font-semibold text-accent dark:text-accent-soft">
                            Oktober 2026
                        </span>
                    </div>

                    {{-- Event Item 1 --}}
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-rose-500/10 font-bold text-rose-600 dark:text-rose-400">
                                <span class="text-[10px] uppercase tracking-wider">OKT</span>
                                <span class="text-base leading-none">04</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="rounded-full bg-rose-500/10 px-2.5 py-0.5 text-[11px] font-semibold text-rose-600 dark:text-rose-400">
                                    Aksi Kasih
                                </span>
                                <h4 class="mt-1.5 text-base font-semibold text-ink">Bakti Sosial &amp; Donor Darah Kasih</h4>
                                <p class="mt-1 text-xs text-muted">Sabtu &bull; 09.00 WITA &bull; Aula Serbaguna</p>
                                <p class="mt-2 text-xs leading-relaxed text-muted">Bakti sosial donor darah bersama PMI dan penyaluran sembako.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Event Item 2 --}}
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-blue-500/10 font-bold text-blue-600 dark:text-blue-400">
                                <span class="text-[10px] uppercase tracking-wider">OKT</span>
                                <span class="text-base leading-none">11</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="rounded-full bg-blue-500/10 px-2.5 py-0.5 text-[11px] font-semibold text-blue-600 dark:text-blue-400">
                                    Pemuda &amp; Mahasiswa
                                </span>
                                <h4 class="mt-1.5 text-base font-semibold text-ink">Retreat Pemuda &amp; Profesional Muda 2026</h4>
                                <p class="mt-1 text-xs text-muted">Minggu – Selasa &bull; Villa Bedugul, Bali</p>
                                <p class="mt-2 text-xs leading-relaxed text-muted">Retreat bertema Berakar dan Berbuah di Era Digital.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Event Item 3 --}}
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-accent/10 font-bold text-accent dark:text-accent-soft">
                                <span class="text-[10px] uppercase tracking-wider">OKT</span>
                                <span class="text-base leading-none">18</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">
                                    Pelayanan
                                </span>
                                <h4 class="mt-1.5 text-base font-semibold text-ink">Lokakarya Musik &amp; Multimedia Gereja</h4>
                                <p class="mt-1 text-xs text-muted">Minggu &bull; 14.00 WITA &bull; Ruang Utama</p>
                                <p class="mt-2 text-xs leading-relaxed text-muted">Pembekalan sound system, live streaming, &amp; worship team.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Event Item 4 --}}
                    <div class="flex flex-col justify-between rounded-2xl border border-line bg-surface p-5 transition-all hover:border-accent/40 hover:shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-emerald-500/10 font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="text-[10px] uppercase tracking-wider">OKT</span>
                                <span class="text-base leading-none">25</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                                    Sakramen
                                </span>
                                <h4 class="mt-1.5 text-base font-semibold text-ink">Baptisan Kudus &amp; Penyerahan Anak</h4>
                                <p class="mt-1 text-xs text-muted">Minggu &bull; 09.00 WITA &bull; Sanctuary Utama</p>
                                <p class="mt-2 text-xs leading-relaxed text-muted">Pelayanan sakramen baptisan kudus jemaat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Ajukan Persembahan dan Donasi --}}
    <section class="border-t border-line py-16 lg:py-24" x-data="{
        copiedBca: false,
        copyAccount(number) {
            navigator.clipboard.writeText(number).then(() => {
                this.copiedBca = true;
                setTimeout(() => this.copiedBca = false, 2500);
            });
        }
    }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
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
                <div class="flex flex-col justify-between rounded-3xl border border-line bg-surface p-7 shadow-sm lg:col-span-6 sm:p-9">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                Transfer Bank
                            </span>
                            <span class="text-xs font-medium text-muted">Rekening Resmi Gereja</span>
                        </div>

                        <div class="mt-6 rounded-2xl border border-line bg-ink/5 p-5">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold tracking-wider text-ink">BCA (Bank Central Asia)</span>
                                <span class="text-xs text-muted">KCP Denpasar</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="font-mono text-2xl font-bold tracking-wider text-ink">146-888-9900</span>
                                <button
                                    type="button"
                                    @click="copyAccount('1468889900')"
                                    class="inline-flex items-center gap-1.5 rounded-full border border-line bg-surface px-3.5 py-1.5 text-xs font-medium text-ink transition-all hover:border-accent hover:text-accent dark:hover:text-accent-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
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
                            <p class="mt-2 text-xs text-muted">Atas Nama: <strong>Gereja Kristen Kemuliaan Allah (GKKD Denpasar)</strong></p>
                        </div>

                        <div class="mt-6 space-y-2.5 text-xs text-muted">
                            <p class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                                <span>Persembahan Persepuluhan, Kolekte Mingguan, dan Syukur</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                                <span>Donasi Bakti Sosial Kasih bagi sesama di Bali</span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-line pt-5">
                        <a
                            href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode('Shalom, saya ingin mengonfirmasi bukti transfer persembahan / donasi GKKD Denpasar.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-line bg-surface px-6 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft {{ $focusRing }}"
                        >
                            <span>Konfirmasi Bukti Transfer via WhatsApp</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                {{-- Kartu QRIS Digital --}}
                <div class="flex flex-col justify-between rounded-3xl border border-line bg-surface p-7 shadow-sm lg:col-span-6 sm:p-9">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                QRIS Standar Nasional
                            </span>
                            <span class="text-xs font-medium text-muted">Semua Bank & e-Wallet</span>
                        </div>

                        <div class="mt-6 grid items-center gap-6 sm:grid-cols-12">
                            <div class="flex flex-col items-center justify-center rounded-2xl border border-line bg-white p-4 shadow-xs sm:col-span-5">
                                <div class="grid aspect-square w-36 place-items-center rounded-xl bg-[#121212] p-2 text-white">
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
                                <span class="mt-2 text-center text-[10px] font-bold tracking-widest text-slate-800 uppercase">GKKD DENPASAR</span>
                            </div>

                            <div class="space-y-3 sm:col-span-7">
                                <h4 class="text-sm font-semibold text-ink">Bebas Biaya Antarbank</h4>
                                <p class="text-xs leading-relaxed text-muted">
                                    Pindai (scan) kode QRIS di samping menggunakan aplikasi perbankan apa pun (BCA, Mandiri, BRI, BNI) atau dompet digital (GoPay, OVO, Dana, ShopeePay).
                                </p>
                                <div class="rounded-xl border border-line bg-ink/5 p-3 text-[11px] text-muted">
                                    <strong class="font-semibold text-ink">NMID:</strong> ID1020268889901<br>
                                    <strong class="font-semibold text-ink">Nama Merchant:</strong> GKKD DENPASAR
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-line pt-5">
                        <p class="text-center text-xs text-muted">
                            <em>"Hendaklah masing-masing memberikan menurut kerelaan hatinya, jangan dengan sedih hati atau karena paksaan."</em> (2 Korintus 9:7)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
