<x-fe.layout.app
    title="Komsel — GKKD Denpasar"
    description="Kelompok sel (komsel) GKKD Denpasar: persekutuan kecil di rumah-rumah jemaat untuk bertumbuh dalam firman dan doa bersama."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Komunitas Sel (Komsel)
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Gereja yang besar tetap terasa seperti keluarga. Dalam komsel, sekelompok kecil jemaat bertemu di rumah untuk mempelajari firman Tuhan, berdoa, dan saling mendukung dalam iman.
                </p>
            </div>
        </div>
    </section>

    {{-- Apa itu Komsel --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <h2 class="text-2xl font-bold text-ink sm:text-3xl">Mengapa ikut komsel?</h2>
                    <div class="mt-8 space-y-6">
                        <div class="rounded-2xl border border-line bg-ink/5 p-6">
                            <h3 class="font-semibold text-ink">1. Persekutuan yang intim</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-muted">
                                Mengenal dan dienal oleh saudara seiman secara langsung, bukan sekadar bersapa di gedung ibadah.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-line bg-ink/5 p-6">
                            <h3 class="font-semibold text-ink">2. Firman yang aplikatif</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-muted">
                                Belajar Alkitab secara dialogis: bertanya, berbagi pergumulan, dan mencari terapan firman dalam keseharian.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-line bg-ink/5 p-6">
                            <h3 class="font-semibold text-ink">3. Dukungan doa dan kasih</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-muted">
                                Saling menopang dalam suka dan duka: mendoakan, mengunjungi, dan menolong satu sama lain sebagai keluarga rohani.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Info Pertemuan --}}
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-line bg-surface p-6 shadow-sm sm:p-8">
                        <h3 class="text-xl font-semibold text-ink">Detail Pertemuan</h3>
                        <dl class="mt-6 space-y-4 text-sm">
                            <div>
                                <dt class="text-xs text-muted">Waktu</dt>
                                <dd class="mt-0.5 font-medium text-ink">Kamis atau Jumat • Pukul 19.30 WITA</dd>
                            </div>
                            <div class="border-t border-line pt-4">
                                <dt class="text-xs text-muted">Lokasi</dt>
                                <dd class="mt-0.5 font-medium text-ink">Rumah-rumah jemaat (Denpasar, Renon, Sanur, Badung)</dd>
                            </div>
                            <div class="border-t border-line pt-4">
                                <dt class="text-xs text-muted">Format</dt>
                                <dd class="mt-0.5 font-medium text-ink">Diskusi terbuka, pemahaman Alkitab, doa bersama</dd>
                            </div>
                        </dl>
                        <a
                            href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya ingin bergabung dengan komsel GKKD Denpasar.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-accent py-3 text-center text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                        >
                            Gabung Komsel via WhatsApp
                        </a>
                        <p class="mt-3 text-center text-xs text-muted">
                            Kami akan mencarikan kelompok sel terdekat dengan domisili Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
