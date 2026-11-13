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
                    Kumpulan pokok-pokok firman Tuhan yang telah disampaikan dalam ibadah. Klik <strong class="font-medium text-ink">Lihat Detail</strong> untuk membaca pembahasan lengkap dan mengunduh materi.
                </p>
            </div>

            {{-- Sermon list --}}
            <div class="mt-10 space-y-4">

                @forelse ($sermons as $sermon)
                    <div class="overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/30">
                        <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-start">

                            {{-- Avatar pengkhotbah (inisial) --}}
                            <div class="shrink-0">
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-tr from-accent-strong to-accent text-lg font-bold text-white ring-2 ring-line">
                                    {{ $sermon->preacher_initials }}
                                </span>
                            </div>

                            {{-- Konten teks --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs font-semibold text-accent dark:text-accent-soft">
                                        {{ $sermon->preached_at->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                <h3 class="mt-2 text-lg font-semibold leading-snug text-ink">
                                    {{ $sermon->title }}
                                </h3>

                                <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm">
                                    <span class="font-medium text-ink">{{ $sermon->preacher }}</span>
                                </div>

                                <p class="mt-3 text-sm leading-relaxed text-muted">
                                    {{ $sermon->summary }}
                                </p>
                            </div>

                            {{-- Tombol detail --}}
                            <div class="shrink-0 sm:ml-2">
                                <a
                                    href="{{ route('kegiatan.khotbah.show', $sermon->slug) }}"
                                    class="inline-flex items-center gap-1.5 rounded-full border border-line px-4 py-2 text-sm font-medium text-ink transition-colors hover:border-accent/50 hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent dark:hover:text-accent-soft"
                                >
                                    <span>Lihat Detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Meta bawah: lokasi & materi --}}
                        <div class="flex flex-wrap items-center gap-3 border-t border-line bg-ink/[0.03] px-6 py-4 dark:bg-white/[0.03]">
                            @if ($sermon->location)
                                <span class="inline-flex items-center gap-1.5 text-xs text-muted">
                                    <i class="fa-solid fa-location-dot text-[11px] text-accent dark:text-accent-soft"></i>
                                    {{ $sermon->location }}
                                </span>
                            @endif
                            <span class="flex-1"></span>
                            <a href="{{ route('kegiatan.khotbah.show', $sermon->slug) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-accent-strong">
                                Baca Khotbah Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-line-strong bg-surface p-10 text-center">
                        <i class="fa-solid fa-microphone-lines text-3xl text-muted"></i>
                        <p class="mt-3 text-sm text-muted">Belum ada rangkuman khotbah untuk ditampilkan.</p>
                    </div>
                @endforelse

            </div>{{-- /sermon list --}}

            @if ($sermons->hasPages())
                <div class="mt-10">
                    {{ $sermons->links() }}
                </div>
            @endif

        </div>
    </section>


</x-fe.layout.app>
