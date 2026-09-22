<x-fe.layout.app
    title="Kegiatan & Pelayanan — GKKD Denpasar"
    description="Pelayanan, komunitas sel (komsel), dan retret/camp GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Jadwal & Komunitas
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Ruang persekutuan untuk setiap musim kehidupan
                </h1>
                <p class="mt-5 text-base leading-relaxed text-muted sm:text-lg">
                    Dari pelayanan tim hingga kelompok sel di rumah-rumah jemaat dan moment retret tahunan, temukan tempat Anda bertumbuh bersama saudara seiman di Denpasar.
                </p>
            </div>
        </div>
    </section>

    {{-- 3 Kegiatan Utama (Asymmetric Bento Grid) --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2">
                {{-- 1. Pelayanan --}}
                <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                    <div class="aspect-16/9 overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/outreach.jpg') }}"
                            alt="Pelayanan GKKD Denpasar"
                            width="600"
                            height="340"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Tim Pelayanan</span>
                            <span class="text-xs text-muted">Bersamaan dengan Ibadah</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Pelayanan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Ragam tim pelayanan — musik, multimedia, diakonia, doa, anak, dan generasi muda — tempat Anda menggerakkan karunia untuk membangun jemaat dan kota.
                        </p>
                        <div class="mt-6 flex items-center justify-between border-t border-line pt-4">
                            <span class="text-xs text-muted">Tim Pelayanan Gereja</span>
                            <a href="{{ route('kegiatan.pelayanan') }}" class="inline-flex items-center text-sm font-semibold text-accent hover:underline dark:text-accent-soft">
                                Pelajari selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. Komsel --}}
                <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                    <div class="flex h-56 flex-col justify-end bg-gradient-to-br from-ink/90 to-ink p-8 text-white sm:h-64">
                        <span class="inline-flex w-fit rounded-full bg-accent px-3 py-1 text-xs font-semibold text-white">
                            Komunitas Sel
                        </span>
                        <h3 class="mt-3 text-2xl font-semibold">Persekutuan di Rumah Jemaat</h3>
                        <p class="mt-2 text-sm text-white/70">
                            Kelompok kecil untuk belajar firman, berdoa, dan saling menopang dalam iman.
                        </p>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Kamis / Jumat</span>
                            <span class="text-xs text-muted">19.30 WITA</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Komsel</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Komunitas sel di rumah-rumah jemaat di sekitar Denpasar, Renon, Sanur, dan Badung — wadah persekutuan intim dan pertumbuhan rohani yang dialogis.
                        </p>
                        <div class="mt-6 flex items-center justify-between border-t border-line pt-4">
                            <span class="text-xs text-muted">Denpasar &amp; Sekitarnya</span>
                            <a href="{{ route('kegiatan.komsel') }}" class="inline-flex items-center text-sm font-semibold text-accent hover:underline dark:text-accent-soft">
                                Pelajari selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Retret/Camp --}}
                <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md md:col-span-2">
                    <div class="aspect-16/9 overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/church-sanctuary.jpg') }}"
                            alt="Retret/Camp GKKD Denpasar"
                            width="1200"
                            height="340"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Tahunan</span>
                            <span class="text-xs text-muted">Keluarga • Pemuda • Anak</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Retret / Camp</h2>
                        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-muted">
                            Keluar dari rutinitas untuk menyendiri bersama Tuhan: retret keluarga, camp pemuda, dan camp anak yang membangun iman, relasi, dan kenangan abadi.
                        </p>
                        <div class="mt-6 flex items-center justify-between border-t border-line pt-4">
                            <span class="text-xs text-muted">Bedugul &amp; Sekitarnya</span>
                            <a href="{{ route('kegiatan.retret-camp') }}" class="inline-flex items-center text-sm font-semibold text-accent hover:underline dark:text-accent-soft">
                                Pelajari selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kalender Ringkas Pekanan --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Rangkuman Waktu Kegiatan Mingguan
                </h2>
                <p class="mt-3 text-base text-muted">
                    Seluruh jadwal waktu menggunakan Waktu Indonesia Tengah (WITA).
                </p>
            </div>

            <div class="mt-10 overflow-hidden rounded-2xl border border-line bg-surface">
                <div class="divide-y divide-line text-sm">
                    <div class="grid grid-cols-1 gap-2 p-5 sm:grid-cols-12 sm:items-center">
                        <div class="font-semibold text-ink sm:col-span-3">Kamis / Jumat (19.30 WITA)</div>
                        <div class="text-ink sm:col-span-5"><strong class="font-medium">Komsel (Komunitas Sel)</strong></div>
                        <div class="text-muted sm:col-span-4">Rumah Jemaat Berdasarkan Wilayah</div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-5 sm:grid-cols-12 sm:items-center">
                        <div class="font-semibold text-ink sm:col-span-3">Setiap Hari Minggu</div>
                        <div class="text-ink sm:col-span-5"><strong class="font-medium">Pelayanan Tim (Musik, Multimedia, Anak)</strong></div>
                        <div class="text-muted sm:col-span-4">Gedung Gereja GKKD</div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-5 sm:grid-cols-12 sm:items-center">
                        <div class="font-semibold text-ink sm:col-span-3">Sabtu ke-2 & ke-4 (10.00 WITA)</div>
                        <div class="text-ink sm:col-span-5"><strong class="font-medium">Pelayanan Sosial & Kunjungan Kasih</strong></div>
                        <div class="text-muted sm:col-span-4">Titik Kumpul Gereja GKKD</div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-5 sm:grid-cols-12 sm:items-center">
                        <div class="font-semibold text-ink sm:col-span-3">September / Desember</div>
                        <div class="text-ink sm:col-span-5"><strong class="font-medium">Retret Keluarga & Camp Pemuda (Tahunan)</strong></div>
                        <div class="text-muted sm:col-span-4">Bedugul, Bali</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Rangkuman Khotbah --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section header --}}
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Rangkuman Khotbah
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Kumpulan pokok-pokok firman Tuhan yang telah disampaikan dalam ibadah. Klik <strong class="font-medium text-ink">Lihat Detail</strong> untuk melihat tanggal, sesi ibadah, dan tautan materi.
                </p>
            </div>

            {{-- Sermon list --}}
            <div class="mt-10 space-y-4">

                {{-- ── Kartu Khotbah 1 ─────────────────────────────────────── --}}
                {{--
                    Field yang ada:
                    - Judul            : "Hidup dalam Kasih Karunia yang Cukup"
                    - Pengkhotbah      : Pdt. Samuel Wijaya
                    - Ayat Referensi   : 2 Korintus 12:7–10
                    - Ibadah Mana      : Ibadah Raya Minggu Pagi (badge)
                    - Tanggal + waktu  : Minggu, 21 September 2025 · 09.00 WITA
                    - Ringkasan        : 2-3 kalimat
                    - (detail) PPT     : tersedia → tombol unduh aktif
                    - (detail) Rekaman : tersedia → tombol tonton aktif
                    - Foto pendeta     : picsum placeholder
                --}}
                <div
                    x-data="{ open: false }"
                    class="overflow-hidden rounded-2xl border border-line bg-surface transition-shadow duration-200"
                    :class="open ? 'shadow-md' : 'hover:border-accent/30'"
                >
                    {{-- Bagian atas kartu (selalu terlihat) --}}
                    <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-start">

                        {{-- Foto Pendeta --}}
                        <div class="shrink-0">
                            <img
                                src="https://picsum.photos/seed/pastor-samuel/80/80"
                                alt="Foto Pdt. Samuel Wijaya"
                                width="64" height="64"
                                class="h-16 w-16 rounded-full object-cover ring-2 ring-line"
                            >
                        </div>

                        {{-- Konten teks --}}
                        <div class="min-w-0 flex-1">
                            {{-- Badge ibadah + tanggal & waktu --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs font-semibold text-accent dark:text-accent-soft">
                                    Ibadah Raya Minggu Pagi
                                </span>
                                <span class="text-xs text-muted">Minggu, 21 September 2025 &bull; 09.00 WITA</span>
                            </div>

                            {{-- Judul khotbah --}}
                            <h3 class="mt-2 text-lg font-semibold leading-snug text-ink">
                                Hidup dalam Kasih Karunia yang Cukup
                            </h3>

                            {{-- Nama pendeta · ayat referensi --}}
                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm">
                                <span class="font-medium text-ink">Pdt. Samuel Wijaya</span>
                                <span class="text-line" aria-hidden="true">&bull;</span>
                                <span class="inline-flex items-center gap-1 text-muted">
                                    {{-- ikon buku kecil --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="h-3.5 w-3.5 shrink-0" aria-hidden="true">
                                        <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687ZM7.5 14.055c-.935-.531-2.12-.603-3.213-.492-1.18.117-2.37.46-3.287.81V3.58c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v10.523ZM7.5 1.75a.75.75 0 0 1 1.5 0 .75.75 0 0 1-1.5 0Z"/>
                                    </svg>
                                    2 Korintus 12:7&ndash;10
                                </span>
                            </div>

                            {{-- Ringkasan / Deskripsi --}}
                            <p class="mt-3 text-sm leading-relaxed text-muted">
                                Paulus mengajarkan bahwa kelemahan bukan penghalang, melainkan ruang di mana kuasa Kristus dinyatakan dengan nyata. Kasih karunia Tuhan selalu cukup untuk menanggung setiap beban kehidupan kita sehari-hari.
                            </p>
                        </div>

                        {{-- Tombol ke halaman detail --}}
                        <div class="shrink-0 sm:ml-2">
                            <a
                                href="{{ route('kegiatan.khotbah.show', 'hidup-dalam-kasih-karunia-yang-cukup') }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-line px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent dark:hover:text-accent-soft"
                            >
                                <span>Lihat Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Panel detail (expand/collapse) --}}
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition duration-200 ease-out"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-150 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="border-t border-line bg-ink/[0.03] px-6 py-5 dark:bg-white/[0.03]"
                    >
                        {{-- Meta: tanggal, ibadah & sesi, lokasi --}}
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <dt class="text-xs text-muted">Tanggal Ibadah</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Minggu, 21 September 2025</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Ibadah &amp; Sesi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ibadah Raya Minggu Pagi &mdash; 09.00 WITA</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Lokasi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ruang Utama Gereja</dd>
                            </div>
                        </dl>

                        {{-- Tautan materi --}}
                        <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-line pt-4">
                            {{-- PPT — tersedia --}}
                            <a href="#" download
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                    <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                </svg>
                                Unduh Slide PPT
                            </a>
                            {{-- Rekaman video — tersedia --}}
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"/>
                                </svg>
                                Tonton Rekaman
                            </a>
                            {{-- Link Halaman Detail Rinci --}}
                            <a href="{{ route('kegiatan.khotbah.show', 'hidup-dalam-kasih-karunia-yang-cukup') }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-accent-strong">
                                Baca Khotbah Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ── Kartu Khotbah 2 ─────────────────────────────────────── --}}
                {{--
                    Field yang ada:
                    - Judul            : "Mengikut Yesus dengan Sepenuh Hati"
                    - Pengkhotbah      : Pdt. Maria Santoso
                    - Ayat Referensi   : Lukas 9:23–25
                    - Ibadah Mana      : Ibadah Raya Minggu Sore (badge)
                    - Tanggal + waktu  : Minggu, 14 September 2025 · 17.00 WITA
                    - (detail) PPT     : tersedia
                    - (detail) Rekaman : belum tersedia → disabled state
                --}}
                <div
                    x-data="{ open: false }"
                    class="overflow-hidden rounded-2xl border border-line bg-surface transition-shadow duration-200"
                    :class="open ? 'shadow-md' : 'hover:border-accent/30'"
                >
                    <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-start">
                        <div class="shrink-0">
                            <img
                                src="https://picsum.photos/seed/pastor-maria/80/80"
                                alt="Foto Pdt. Maria Santoso"
                                width="64" height="64"
                                class="h-16 w-16 rounded-full object-cover ring-2 ring-line"
                            >
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs font-semibold text-accent dark:text-accent-soft">
                                    Ibadah Raya Minggu Sore
                                </span>
                                <span class="text-xs text-muted">Minggu, 14 September 2025 &bull; 17.00 WITA</span>
                            </div>

                            <h3 class="mt-2 text-lg font-semibold leading-snug text-ink">
                                Mengikut Yesus dengan Sepenuh Hati
                            </h3>

                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm">
                                <span class="font-medium text-ink">Pdt. Maria Santoso</span>
                                <span class="text-line" aria-hidden="true">&bull;</span>
                                <span class="inline-flex items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="h-3.5 w-3.5 shrink-0" aria-hidden="true">
                                        <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687ZM7.5 14.055c-.935-.531-2.12-.603-3.213-.492-1.18.117-2.37.46-3.287.81V3.58c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v10.523ZM7.5 1.75a.75.75 0 0 1 1.5 0 .75.75 0 0 1-1.5 0Z"/>
                                    </svg>
                                    Lukas 9:23&ndash;25
                                </span>
                            </div>

                            <p class="mt-3 text-sm leading-relaxed text-muted">
                                Panggilan menyangkal diri dan memikul salib bukan sebuah beban, melainkan undangan untuk menemukan kehidupan yang sesungguhnya bersama Kristus setiap hari.
                            </p>
                        </div>

                        {{-- Tombol ke halaman detail --}}
                        <div class="shrink-0 sm:ml-2">
                            <a
                                href="{{ route('kegiatan.khotbah.show', 'mengikut-yesus-dengan-sepenuh-hati') }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-line px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent dark:hover:text-accent-soft"
                            >
                                <span>Lihat Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition duration-200 ease-out"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-150 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="border-t border-line bg-ink/[0.03] px-6 py-5 dark:bg-white/[0.03]"
                    >
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <dt class="text-xs text-muted">Tanggal Ibadah</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Minggu, 14 September 2025</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Ibadah &amp; Sesi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ibadah Raya Minggu Sore &mdash; 17.00 WITA</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Lokasi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ruang Utama Gereja</dd>
                            </div>
                        </dl>

                        <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-line pt-4">
                            <a href="#" download
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                    <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                </svg>
                                Unduh Slide PPT
                            </a>
                            {{-- Rekaman belum tersedia — disabled slot --}}
                            <span
                                class="inline-flex select-none items-center gap-2 rounded-full border border-line/50 px-4 py-2 text-sm text-muted/60"
                                aria-label="Rekaman video belum tersedia">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"/>
                                </svg>
                                Rekaman belum tersedia
                            </span>
                            {{-- Link Halaman Detail Rinci --}}
                            <a href="{{ route('kegiatan.khotbah.show', 'mengikut-yesus-dengan-sepenuh-hati') }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-accent-strong">
                                Baca Khotbah Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ── Kartu Khotbah 3 ─────────────────────────────────────── --}}
                {{--
                    Field yang ada:
                    - Judul            : "Doa yang Mengubah Keadaan"
                    - Pengkhotbah      : Ev. Yohanes Pratama
                    - Ayat Referensi   : Yakobus 5:13–16
                    - Ibadah Mana      : Ibadah Doa Bersama (badge — warna netral)
                    - Tanggal + waktu  : Rabu, 10 September 2025 · 19.00 WITA
                    - (detail) PPT     : belum tersedia → disabled
                    - (detail) Rekaman : tersedia → tombol aktif
                --}}
                <div
                    x-data="{ open: false }"
                    class="overflow-hidden rounded-2xl border border-line bg-surface transition-shadow duration-200"
                    :class="open ? 'shadow-md' : 'hover:border-accent/30'"
                >
                    <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-start">
                        <div class="shrink-0">
                            <img
                                src="https://picsum.photos/seed/evangelist-yohanes/80/80"
                                alt="Foto Ev. Yohanes Pratama"
                                width="64" height="64"
                                class="h-16 w-16 rounded-full object-cover ring-2 ring-line"
                            >
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                {{-- Badge warna netral untuk ibadah non-Raya --}}
                                <span class="rounded-full bg-ink/10 px-2.5 py-0.5 text-xs font-semibold text-ink dark:bg-white/10">
                                    Ibadah Doa Bersama
                                </span>
                                <span class="text-xs text-muted">Rabu, 10 September 2025 &bull; 19.00 WITA</span>
                            </div>

                            <h3 class="mt-2 text-lg font-semibold leading-snug text-ink">
                                Doa yang Mengubah Keadaan
                            </h3>

                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm">
                                <span class="font-medium text-ink">Ev. Yohanes Pratama</span>
                                <span class="text-line" aria-hidden="true">&bull;</span>
                                <span class="inline-flex items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="h-3.5 w-3.5 shrink-0" aria-hidden="true">
                                        <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687ZM7.5 14.055c-.935-.531-2.12-.603-3.213-.492-1.18.117-2.37.46-3.287.81V3.58c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v10.523ZM7.5 1.75a.75.75 0 0 1 1.5 0 .75.75 0 0 1-1.5 0Z"/>
                                    </svg>
                                    Yakobus 5:13&ndash;16
                                </span>
                            </div>

                            <p class="mt-3 text-sm leading-relaxed text-muted">
                                Doa orang benar sangat besar kuasanya. Saat jemaat berdoa bersama dengan iman, Tuhan bergerak memulihkan, menyembuhkan, dan mengubah situasi yang tampak mustahil.
                            </p>
                        </div>

                        {{-- Tombol ke halaman detail --}}
                        <div class="shrink-0 sm:ml-2">
                            <a
                                href="{{ route('kegiatan.khotbah.show', 'doa-yang-mengubah-keadaan') }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-line px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent dark:hover:text-accent-soft"
                            >
                                <span>Lihat Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition duration-200 ease-out"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-150 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="border-t border-line bg-ink/[0.03] px-6 py-5 dark:bg-white/[0.03]"
                    >
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <dt class="text-xs text-muted">Tanggal Ibadah</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Rabu, 10 September 2025</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Ibadah &amp; Sesi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ibadah Doa Bersama &mdash; 19.00 WITA</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted">Lokasi</dt>
                                <dd class="mt-0.5 text-sm font-medium text-ink">Ruang Konseling &amp; Online</dd>
                            </div>
                        </dl>

                        <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-line pt-4">
                            {{-- PPT belum tersedia — disabled --}}
                            <span
                                class="inline-flex select-none items-center gap-2 rounded-full border border-line/50 px-4 py-2 text-sm text-muted/60"
                                aria-label="Slide belum tersedia">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                    <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                </svg>
                                Slide belum tersedia
                            </span>
                            {{-- Rekaman — tersedia --}}
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="h-4 w-4 shrink-0" aria-hidden="true">
                                    <path d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"/>
                                </svg>
                                Tonton Rekaman
                            </a>
                            {{-- Link Halaman Detail Rinci --}}
                            <a href="{{ route('kegiatan.khotbah.show', 'doa-yang-mengubah-keadaan') }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-accent-strong">
                                Baca Khotbah Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>{{-- /sermon list --}}
        </div>
    </section>

</x-fe.layout.app>
