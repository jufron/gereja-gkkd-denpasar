<x-fe.layout.app
    title="Retret & Camp — GKKD Denpasar"
    description="Retret dan camp tahunan GKKD Denpasar: menyendiri bersama Tuhan, membangun relasi, dan memperlengkapi generasi muda."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Retret / Camp
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Meluangkan waktu keluar dari rutinitas untuk menyendiri bersama Tuhan. Retret dan camp GKKD Denpasar menjadi moment pembaharuan iman, penguatan relasi, dan pelepasan karunia bagi setiap generasi.
                </p>
            </div>
        </div>
    </section>

    {{-- Agenda Retret --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                {{-- 1. Retret Keluarga --}}
                <div class="flex flex-col overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md lg:flex-row">
                    <div class="aspect-16/9 overflow-hidden bg-ink/5 lg:aspect-auto lg:w-72">
                        <img
                            src="{{ asset('images/fellowship.jpg') }}"
                            alt="Retret keluarga GKKD Denpasar"
                            width="600"
                            height="340"
                            class="h-full w-full object-cover"
                        >
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Retret Keluarga</span>
                            <span class="text-xs text-muted">September 2026</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Retret Keluarga: Rumah yang Berakar pada Kristus</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Dua hari penuh di Bedugul untuk pasangan dan keluarga: ibadah, seminar keluarga Kristen, dan aktivasi ikatan orang tua–anak.
                        </p>
                        <div class="mt-6 flex items-center gap-3 border-t border-line pt-4 text-xs text-muted">
                            <span>Bedugul, Bali</span>
                            <span aria-hidden="true">&bull;</span>
                            <span>Pendaftaran dibuka</span>
                        </div>
                    </div>
                </div>

                {{-- 2. Camp Pemuda --}}
                <div class="flex flex-col overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md lg:flex-row">
                    <div class="aspect-16/9 overflow-hidden bg-ink/5 lg:aspect-auto lg:w-72">
                        <img
                            src="{{ asset('images/church-sanctuary.jpg') }}"
                            alt="Camp pemuda GKKD Denpasar"
                            width="600"
                            height="340"
                            class="h-full w-full object-cover"
                        >
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Camp Pemuda</span>
                            <span class="text-xs text-muted">Desember 2026</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Camp Pemuda &amp; Profesional Muda</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Persatuan kaum muda dalam penyembahan, pendalaman firman, dan game seru — memperlengkapi mereka beriman di era digital.
                        </p>
                        <div class="mt-6 flex items-center gap-3 border-t border-line pt-4 text-xs text-muted">
                            <span>Bedugul, Bali</span>
                            <span aria-hidden="true">&bull;</span>
                            <span>Pendaftaran awal dibuka</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Camp Anak --}}
                <div class="flex flex-col overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md lg:flex-row">
                    <div class="aspect-16/9 overflow-hidden bg-ink/5 lg:aspect-auto lg:w-72">
                        <img
                            src="{{ asset('images/sunday-school.jpg') }}"
                            alt="Camp anak GKKD Denpasar"
                            width="600"
                            height="340"
                            class="h-full w-full object-cover"
                        >
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Camp Anak</span>
                            <span class="text-xs text-muted">Juni 2026</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-ink">Camp Sekolah Minggu: Petualangan Firman</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Belajar firman melalui permainan, kerajinan tangan, dan berkemah bersama teman sebaya dengan pendampingan guru-guru penuh kasih.
                        </p>
                        <div class="mt-6 flex items-center gap-3 border-t border-line pt-4 text-xs text-muted">
                            <span>Denpasar, Bali</span>
                            <span aria-hidden="true">&bull;</span>
                            <span>Terlaksana</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Ingin tahu jadwal retret berikutnya?
                </h2>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Hubungi kami untuk informasi pendaftaran dan kebutuhan retret atau camp kelompok Anda.
                </p>
                <a
                    href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya ingin info retret/camp GKKD Denpasar.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-8 inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                >
                    Tanya Info via WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-fe.layout.app>
