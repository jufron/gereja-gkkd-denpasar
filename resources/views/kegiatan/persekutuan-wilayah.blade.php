<x-fe.layout.app
    title="Persekutuan Wilayah — GKKD Denpasar"
    description="Komunitas sel dan kelompok kecil GKKD Denpasar yang tersebar di berbagai wilayah kota Denpasar dan sekitarnya."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Persekutuan Wilayah
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Gereja bukan hanya gedung besar pada hari Minggu, melainkan keluarga yang saling menguatkan di tengah rutinitas pekan hidup.
                </p>
            </div>
        </div>
    </section>

    {{-- Penjelasan Komunitas Sel & Foto --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
            <div>
                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                    Komunitas Sel / Kelompok Kecil
                </span>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Tempat saling berbagi, belajar firman, dan bertumbuh
                </h2>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Dalam kelompok kecil yang beranggotakan 8–15 orang, setiap orang memiliki ruang untuk didengarkan, didoakan, dan membangun relasi yang otentik.
                </p>

                <div class="mt-8 space-y-4">
                    <div class="rounded-2xl border border-line bg-surface p-5">
                        <h3 class="font-semibold text-ink">Diskusi Firman yang Dialogis</h3>
                        <p class="mt-1 text-sm text-muted">Bukan khotbah satu arah, melainkan mendiskusikan aplikasi firman Minggu dalam pergumulan nyata pekerjaan dan keluarga.</p>
                    </div>

                    <div class="rounded-2xl border border-line bg-surface p-5">
                        <h3 class="font-semibold text-ink">Saling Mendoakan & Menopang</h3>
                        <p class="mt-1 text-sm text-muted">Bila ada anggota yang sakit, berduka, atau merayakan kelulusan, komunitas hadir memberikan dukungan riil.</p>
                    </div>

                    <div class="rounded-2xl border border-line bg-surface p-5">
                        <h3 class="font-semibold text-ink">Makan Bersama & Keakraban</h3>
                        <p class="mt-1 text-sm text-muted">Suasana informal yang santai dengan secangkir teh dan hidangan ringan khas kebersamaan keluarga.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-line shadow-md">
                <img
                    src="{{ asset('images/fellowship.jpg') }}"
                    alt="Persekutuan jemaat dalam komunitas wilayah"
                    width="700"
                    height="450"
                    class="h-full w-full object-cover"
                >
            </div>
        </div>
    </section>

    {{-- Daftar Wilayah Kelompok Sel --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Sebaran Wilayah di Denpasar & Sekitarnya
                </h2>
                <p class="mt-3 text-base text-muted">
                    Pertemuan diadakan setiap Kamis atau Jumat malam pukul 19.30 WITA di rumah jemaat tuan rumah yang bergantian secara nyaman.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Wilayah 1</span>
                    <h3 class="mt-4 text-lg font-semibold text-ink">Denpasar Barat</h3>
                    <p class="mt-2 text-sm text-muted">Meliputi area Teuku Umar, Gatot Subroto Barat, Mahendradatta, dan Gunung Agung.</p>
                    <p class="mt-4 text-xs font-medium text-ink">Jadwal: Jumat, 19.30 WITA</p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Wilayah 2</span>
                    <h3 class="mt-4 text-lg font-semibold text-ink">Denpasar Timur & Renon</h3>
                    <p class="mt-2 text-sm text-muted">Meliputi area Renon, Hayam Wuruk, Tantular, Panjer, dan Tohpati.</p>
                    <p class="mt-4 text-xs font-medium text-ink">Jadwal: Kamis, 19.30 WITA</p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Wilayah 3</span>
                    <h3 class="mt-4 text-lg font-semibold text-ink">Denpasar Selatan & Sanur</h3>
                    <p class="mt-2 text-sm text-muted">Meliputi area Bypass Ngurah Rai, Sidakarya, Sanur, dan Sesetan.</p>
                    <p class="mt-4 text-xs font-medium text-ink">Jadwal: Jumat, 19.30 WITA</p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">Wilayah 4</span>
                    <h3 class="mt-4 text-lg font-semibold text-ink">Kuta & Badung</h3>
                    <p class="mt-2 text-sm text-muted">Meliputi area Sunset Road, Dewi Sri, Seminyak, Jimbaran, dan Dalung.</p>
                    <p class="mt-4 text-xs font-medium text-ink">Jadwal: Kamis, 19.30 WITA</p>
                </div>
            </div>

            <div class="mt-12 rounded-2xl border border-line bg-surface p-8 text-center sm:p-10">
                <h3 class="text-xl font-semibold text-ink">Ingin Bergabung dengan Komunitas Sel Terdekat?</h3>
                <p class="mx-auto mt-2 max-w-xl text-sm leading-relaxed text-muted">
                    Hubungi tim kami. Kami akan dengan senang hati menghubungkan Anda dengan koordinator wilayah yang ramah dan dekat dengan domisili Anda.
                </p>
                <div class="mt-6">
                    <a
                        href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya ingin info bergabung ke Persekutuan Wilayah GKKD Denpasar.') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                    >
                        Tanyakan via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
