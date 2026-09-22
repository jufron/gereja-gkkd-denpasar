<x-fe.layout.app
    title="Pelayanan — GKKD Denpasar"
    description="Ragam pelayanan dan tim pelayanan di GKKD Denpasar: musik, multimedia, diakonia, doa, dan sekolah minggu."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Pelayanan
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Setiap jemaat dianugerahi karunia untuk melayani. Temukan panggilan Anda dalam salah satu tim pelayanan GKKD Denpasar dan bertumbuh melayani Tuhan bersama saudara seiman.
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar Pelayanan --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                {{-- 1. Pelayanan Musik & Pujian --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Musisi
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Pelayanan Musik &amp; Pujian</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Memimpin jemaat masuk ke hadirat Tuhan melalui pujian dan penyembahan dalam setiap ibadah raya maupun persekutuan kecil.
                    </p>
                </div>

                {{-- 2. Multimedia & Tata Ibadah --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Multimedia
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Multimedia &amp; Tata Ibadah</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Penunjang teknis ibadah: tata latar, lirik, audio, siaran streaming, hingga dokumentasi setiap kegiatan gereja.
                    </p>
                </div>

                {{-- 3. Diakonia & Aksi Kasih --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Diakonia
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Diakonia &amp; Aksi Kasih</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Wujud nyata kasih Kristus melalui kunjungan jemaat, bakti sosial, donor darah, dan bantuan bagi yang membutuhkan di sekitar Denpasar.
                    </p>
                </div>

                {{-- 4. Tim Doa & Konseling --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Doa
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Tim Doa &amp; Konseling</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Mendampingi jemaat dalam doa syafaat dan konseling pastoral secara rahasia, penuh empati, dan berlandaskan firman Tuhan.
                    </p>
                </div>

                {{-- 5. Sekolah Minggu --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Guru Anak
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Pelayanan Anak</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Mengajar dan mendampingi anak-anak usia 3–12 tahun mengenal Yesus melalui cerita Alkitab, permainan, dan aktivitas kreatif.
                    </p>
                </div>

                {{-- 6. Pelayanan Pemuda --}}
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-all hover:border-accent/40 hover:shadow-md sm:p-8">
                    <span class="inline-flex w-fit rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        Tim Pemuda
                    </span>
                    <h2 class="mt-4 text-xl font-semibold text-ink">Pelayanan Generasi Muda</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Memperlengkapi pemuda dan mahasiswa menjadi agen perubahan di kampus, lingkungan kerja, dan keluarga melalui pendalaman firman dan persekutuan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Bergabung --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Siap melayani bersama kami?
                </h2>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Ceritakan minat dan karunia Anda, kami akan menghubungkan Anda dengan tim pelayanan yang sesuai.
                </p>
                <a
                    href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya ingin bertanya tentang pelayanan di GKKD Denpasar.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-8 inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                >
                    Hubungi Kami via WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-fe.layout.app>
