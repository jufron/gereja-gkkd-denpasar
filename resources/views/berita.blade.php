<x-fe.layout.app
    title="Berita & Warta — GKKD Denpasar"
    description="Kabar terkini seputar kegiatan jemaat, pengumuman pelayanan, dan artikel renungan firman di GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Warta & Kabar Jemaat
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Berita, Pengumuman, dan Renungan
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Ikuti perkembangan pelayanan gereja, agenda khusus jemaat, dan renungan firman peneguh iman setiap pekan.
                </p>
            </div>
        </div>
    </section>

    {{-- Artikel Utama / Berita Sorotan --}}
    <section class="py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="group relative overflow-hidden rounded-3xl border border-line bg-surface shadow-sm transition-all hover:border-accent/40">
                <div class="grid items-center lg:grid-cols-12">
                    <div class="p-8 sm:p-12 lg:col-span-7">
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                Sorotan Minggu Ini
                            </span>
                            <span class="text-xs text-muted">20 September 2026</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                            Menghadirkan Damai Kristus di Tengah Dinamika Kota Denpasar
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-muted">
                            Ringkasan seri khotbah bulan ini mengenai panggilan orang percaya untuk hidup sebagai garam dan terang: menjaga integritas di tempat kerja, memelihara kerukunan antarumat beragama di Bali, dan mengasihi tanpa pamrih.
                        </p>
                        <div class="mt-6 flex items-center gap-4">
                            <span class="text-xs font-medium text-muted">Oleh Tim Pastoral GKKD</span>
                            <span class="text-xs text-muted">•</span>
                            <span class="text-xs font-medium text-accent dark:text-accent-soft">Bacaan 4 Menit</span>
                        </div>
                    </div>

                    <div class="aspect-16/10 overflow-hidden bg-ink/5 lg:col-span-5 lg:aspect-auto lg:h-full">
                        <img
                            src="{{ asset('images/church-sanctuary.jpg') }}"
                            alt="Suasana ibadah khotbah GKKD Denpasar"
                            width="600"
                            height="450"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Grid Berita & Pengumuman --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h2 class="text-3xl font-semibold tracking-tight text-ink">
                        Warta & Informasi Pelayanan
                    </h2>
                    <p class="mt-2 text-sm text-muted">Kabar kegiatan terbaru dan rencana pelayanan mendatang.</p>
                </div>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                {{-- Kartu 1 --}}
                <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                    <div>
                        <div class="aspect-16/10 overflow-hidden bg-ink/5">
                            <img
                                src="{{ asset('images/outreach.jpg') }}"
                                alt="Bakti sosial di Denpasar"
                                width="500"
                                height="300"
                                class="h-full w-full object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">Aksi Kasih</span>
                                <span class="text-xs text-muted">15 September 2026</span>
                            </div>
                            <h3 class="mt-3 text-lg font-semibold text-ink">
                                Laporan Kasih: Penyaluran Paket Sembako & Alat Tulis
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                Puji Tuhan, tim Diakonia telah mendistribusikan 120 paket perlengkapan sekolah bagi anak-anak dan kebutuhan pokok keluarga di wilayah Denpasar.
                            </p>
                        </div>
                    </div>
                    <div class="border-t border-line px-6 py-4">
                        <span class="text-xs font-semibold text-accent dark:text-accent-soft">Selesai Terlaksana &check;</span>
                    </div>
                </article>

                {{-- Kartu 2 --}}
                <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                    <div>
                        <div class="aspect-16/10 overflow-hidden bg-ink/5">
                            <img
                                src="{{ asset('images/sunday-school.jpg') }}"
                                alt="Kurikulum Sekolah Minggu baru"
                                width="500"
                                height="300"
                                class="h-full w-full object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">Sekolah Minggu</span>
                                <span class="text-xs text-muted">10 September 2026</span>
                            </div>
                            <h3 class="mt-3 text-lg font-semibold text-ink">
                                Penerimaan Murid Baru Kelas Anak Semester Ganjil
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                Kami menyambut anak-anak usia 1 hingga 12 tahun untuk belajar firman dengan modul karakter Buah Roh yang seru dan interaktif setiap Minggu.
                            </p>
                        </div>
                    </div>
                    <div class="border-t border-line px-6 py-4">
                        <a href="{{ route('kegiatan.sekolah-minggu') }}" class="text-xs font-semibold text-accent hover:underline dark:text-accent-soft">
                            Info Pendaftaran Sekolah Minggu &rarr;
                        </a>
                    </div>
                </article>

                {{-- Kartu 3 --}}
                <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                    <div>
                        <div class="aspect-16/10 overflow-hidden bg-ink/5">
                            <img
                                src="{{ asset('images/fellowship.jpg') }}"
                                alt="Pertemuan jemaat wilayah"
                                width="500"
                                height="300"
                                class="h-full w-full object-cover"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">Komunitas Sel</span>
                                <span class="text-xs text-muted">05 September 2026</span>
                            </div>
                            <h3 class="mt-3 text-lg font-semibold text-ink">
                                Pembukaan Kelompok Sel Baru Wilayah Kuta & Badung
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                Menjawab kebutuhan jemaat yang berdomisili di sekitar Sunset Road dan Kuta, kini dibuka pertemuan komunitas sel setiap hari Kamis malam.
                            </p>
                        </div>
                    </div>
                    <div class="border-t border-line px-6 py-4">
                        <a href="{{ route('kegiatan.persekutuan-wilayah') }}" class="text-xs font-semibold text-accent hover:underline dark:text-accent-soft">
                            Gabung Kelompok Sel &rarr;
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</x-fe.layout.app>
