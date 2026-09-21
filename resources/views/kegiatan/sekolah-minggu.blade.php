<x-fe.layout.app
    title="Sekolah Minggu — GKKD Denpasar"
    description="Pendidikan iman anak yang hangat, aman, dan kreatif setiap Minggu pukul 09.00 WITA di GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Sekolah Minggu Anak
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Menanamkan benih firman Tuhan dan karakter Kristus sejak usia dini dalam suasana yang riang, kreatif, dan penuh kasih.
                </p>
            </div>
        </div>
    </section>

    {{-- Highlight Foto & Nilai Pelayanan Anak --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-line shadow-md">
                <img
                    src="{{ asset('images/sunday-school.jpg') }}"
                    alt="Aktivitas ceria anak-anak Sekolah Minggu GKKD Denpasar"
                    width="700"
                    height="450"
                    class="h-full w-full object-cover"
                >
            </div>

            <div>
                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                    Setiap Minggu • 09.00 WITA
                </span>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Ruang aman bagi buah hati Anda untuk bertumbuh
                </h2>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Kami meyakini anak-anak adalah pahlawan iman masa depan. Melalui pendekatan bercerita yang hidup, aktivitas seni kreatif, dan musik ceria, mereka diajak mengenal kasih Yesus secara nyata.
                </p>

                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent/10 text-accent dark:text-accent-soft">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-sm text-ink"><strong class="font-semibold">Guru-guru Berdedikasi:</strong> Didampingi kakak-kakak pembimbing yang penuh kesabaran dan terlatih.</p>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent/10 text-accent dark:text-accent-soft">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-sm text-ink"><strong class="font-semibold">Keamanan & Kenyamanan Terjamin:</strong> Ruangan ber-AC, bersih, dan sistem penjemputan anak yang tertib.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pembagian Kelas Usia --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Kelas Berdasarkan Kelompok Usia
                </h2>
                <p class="mt-3 text-base text-muted">
                    Materi dan metode ajar disesuaikan dengan tahapan perkembangan motorik dan pemahaman anak.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-3">
                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Usia 1–3 Tahun
                    </span>
                    <h3 class="mt-4 text-xl font-semibold text-ink">Kelas Balita</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Didampingi orang tua dengan lagu-lagu sederhana, pengenalan kasih Allah lewat sensori, dan suasana ramah balita.
                    </p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Usia 4–7 Tahun
                    </span>
                    <h3 class="mt-4 text-xl font-semibold text-ink">Kelas Pratama</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Cerita Alkitab bergambar, kerajinan tangan, hafalan ayat pendek, serta belajar berdoa dan bersyukur bersama teman-teman.
                    </p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Usia 8–12 Tahun
                    </span>
                    <h3 class="mt-4 text-xl font-semibold text-ink">Kelas Madya</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Mendalami isi Alkitab secara mendalam, diskusi nilai kejujuran dan persahabatan, serta panggung mini untuk melatih talenta anak.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
