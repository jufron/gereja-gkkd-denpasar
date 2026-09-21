<x-fe.layout.app
    title="Ibadah Raya — GKKD Denpasar"
    description="Informasi sesi, alur liturgi, dan panduan jemaat untuk Ibadah Raya Minggu di GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Ibadah Raya Hari Minggu
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Saat seluruh jemaat berkumpul merayakan kebaikan Tuhan melalui pujian yang penuh sukacita dan pemberitaan firman yang berkuasa.
                </p>
            </div>
        </div>
    </section>

    {{-- Sesi Ibadah & Detail --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <h2 class="text-3xl font-semibold tracking-tight text-ink">
                        Dua Pilihan Sesi Ibadah
                    </h2>
                    <p class="mt-3 text-base leading-relaxed text-muted">
                        Pilih waktu yang paling sesuai untuk Anda dan keluarga. Keduanya menyajikan pesan firman dan atmosfer ibadah yang sama.
                    </p>

                    <div class="mt-8 grid gap-6 sm:grid-cols-2">
                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Sesi 1 • Pagi</span>
                            <h3 class="mt-4 text-2xl font-bold text-ink">09.00 WITA</h3>
                            <p class="mt-2 text-sm text-muted">
                                Berjalan bersamaan dengan ibadah Sekolah Minggu untuk anak-anak. Cocok bagi keluarga dengan balita dan anak usia sekolah.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Sesi 2 • Sore</span>
                            <h3 class="mt-4 text-2xl font-bold text-ink">17.00 WITA</h3>
                            <p class="mt-2 text-sm text-muted">
                                Suasana ibadah petang yang teduh dan akrab. Banyak dihadiri mahasiswa, kaum muda, dan pekerja profesional.
                            </p>
                        </div>
                    </div>

                    {{-- Alur Ibadah --}}
                    <div class="mt-12">
                        <h3 class="text-xl font-semibold text-ink">Apa yang Bisa Anda Harapkan dalam Ibadah?</h3>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl border border-line bg-ink/5 p-5">
                                <h4 class="font-semibold text-ink">Pujian & Penyembahan Kontemporer (± 30 menit)</h4>
                                <p class="mt-1 text-sm text-muted">Lagu-lagu pujian yang menuntun hati menyembah Tuhan secara intim dan penuh rasa syukur.</p>
                            </div>

                            <div class="rounded-2xl border border-line bg-ink/5 p-5">
                                <h4 class="font-semibold text-ink">Pengajaran Firman Tuhan (± 40 menit)</h4>
                                <p class="mt-1 text-sm text-muted">Pemberitaan firman yang berakar kuat pada Alkitab, relevan, dan aplikatif untuk pergumulan hidup harian.</p>
                            </div>

                            <div class="rounded-2xl border border-line bg-ink/5 p-5">
                                <h4 class="font-semibold text-ink">Perjamuan Kudus (Minggu Pertama Setiap Bulan)</h4>
                                <p class="mt-1 text-sm text-muted">Mengingat karya penebusan Kristus di kayu salib bersama seluruh tubuh Kristus.</p>
                            </div>

                            <div class="rounded-2xl border border-line bg-ink/5 p-5">
                                <h4 class="font-semibold text-ink">Doa Konseling & Berkat Pribadi</h4>
                                <p class="mt-1 text-sm text-muted">Seusai ibadah, pengerja dan hamba Tuhan siap mendoakan pergumulan, kesehatan, atau kebutuhan khusus Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Panduan Pengunjung & Foto --}}
                <div class="lg:col-span-5">
                    <div class="overflow-hidden rounded-2xl border border-line shadow-md">
                        <img
                            src="{{ asset('images/church-sanctuary.jpg') }}"
                            alt="Suasana ruang ibadah GKKD Denpasar"
                            width="600"
                            height="400"
                            class="h-64 w-full object-cover"
                        >
                        <div class="bg-surface p-6">
                            <h3 class="text-lg font-semibold text-ink">Panduan Pengunjung Baru</h3>
                            <ul class="mt-4 space-y-3 text-sm text-muted">
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-accent text-[10px] text-white">&check;</span>
                                    <span>Tiba 15 menit sebelum ibadah untuk mendapatkan tempat duduk dan parkir yang nyaman.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-accent text-[10px] text-white">&check;</span>
                                    <span>Tim penyambut (usher) akan dengan senang hati membantu Anda dan mengantar ke ruang ibadah.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-accent text-[10px] text-white">&check;</span>
                                    <span>Pakaian bebas rapi, sopan, atau batik. Ruang ibadah berpendingin udara (AC).</span>
                                </li>
                            </ul>

                            <div class="mt-6 border-t border-line pt-4">
                                <a
                                    href="{{ route('kontak') }}"
                                    class="inline-flex w-full items-center justify-center rounded-full bg-accent py-2.5 text-center text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                                >
                                    Petunjuk Lokasi & Rute
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
