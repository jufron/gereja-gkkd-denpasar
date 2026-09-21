<x-fe.layout.app
    title="Tentang Kami — GKKD Denpasar"
    description="Mengenal visi, misi, nilai iman, dan perjalanan pelayanan GKKD Denpasar dalam memberkati jemaat serta masyarakat di Bali."
>
    {{-- Header Halaman --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Gereja Kristen Kemuliaan Allah
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Bertumbuh dalam kasih Kristus, melayani dengan kerendahan hati
                </h1>
                <p class="mt-5 text-base leading-relaxed text-muted sm:text-lg">
                    GKKD Denpasar hadir sebagai wadah persekutuan bagi setiap orang yang rindu berakar dalam firman Tuhan dan menjadi berkat bagi sesama di Bali.
                </p>
            </div>
        </div>
    </section>

    {{-- Visi & Misi --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5">
                    <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                        Arah langkah dan panggilan kami
                    </h2>
                    <p class="mt-4 text-base leading-relaxed text-muted">
                        Setiap program, ibadah, dan persekutuan yang kami bangun diarahkan untuk memuliakan Allah dan membimbing jemaat menjadi murid Kristus yang berbuah.
                    </p>

                    <div class="mt-8 rounded-2xl border border-line bg-surface p-6">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent/10 font-bold text-accent dark:text-accent-soft">
                                V
                            </span>
                            <h3 class="text-lg font-semibold text-ink">Visi Gereja</h3>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Menjadi jemaat yang penuh kemuliaan Allah, berakar kuat dalam kebenaran Alkitab, serta berdampak nyata bagi transformasi keluarga dan masyarakat di kota Denpasar dan sekitarnya.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="rounded-2xl border border-line bg-ink/5 p-8">
                        <h3 class="text-xl font-semibold text-ink">Misi Pelayanan</h3>
                        <div class="mt-6 space-y-6">
                            <div class="flex gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent text-sm font-semibold text-white">
                                    1
                                </span>
                                <div>
                                    <h4 class="text-base font-semibold text-ink">Membangun Kehidupan Penyembahan</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-muted">
                                        Menuntun setiap jemaat mengalami perjumpaan pribadi dengan Tuhan melalui ibadah yang intim, tulus, dan berpusat pada Injil.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent text-sm font-semibold text-white">
                                    2
                                </span>
                                <div>
                                    <h4 class="text-base font-semibold text-ink">Pemuridan yang Mengubahkan Karakter</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-muted">
                                        Melatih dan memperlengkapi jemaat dari anak-anak hingga dewasa agar memiliki kedewasaan rohani dan integritas iman.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent text-sm font-semibold text-white">
                                    3
                                </span>
                                <div>
                                    <h4 class="text-base font-semibold text-ink">Komunitas yang Mengasihi</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-muted">
                                        Menumbuhkan persekutuan sel (komunitas wilayah) tempat jemaat saling mendukung, menopang dalam doa, dan berbagi sukacita maupun beban.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent text-sm font-semibold text-white">
                                    4
                                </span>
                                <div>
                                    <h4 class="text-base font-semibold text-ink">Kepedulian Sosial & Misi</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-muted">
                                        Menjadi berkat konkrit bagi kota melalui aksi sosial kemanusiaan, pemberdayaan keluarga, dan kepedulian bagi sesama tanpa memandang latar belakang.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Foto & Cerita Komunitas di Bali --}}
    <section class="border-t border-line bg-surface py-16 lg:py-24">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl border border-line shadow-md">
                <img
                    src="{{ asset('images/fellowship.jpg') }}"
                    alt="Komunitas jemaat GKKD di Denpasar"
                    width="700"
                    height="450"
                    loading="lazy"
                    class="h-full w-full object-cover"
                >
            </div>

            <div>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Perjalanan iman di tanah dewata
                </h2>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Melayani di Bali memberikan kami keistimewaan untuk hidup berdampingan dalam harmoni, menghormati kearifan lokal, dan memancarkan kasih Kristus secara bersahaja.
                </p>
                <p class="mt-4 text-base leading-relaxed text-muted">
                    Sejak dirintis, GKKD Denpasar berkomitmen menjadi keluarga yang inklusif bagi siapa saja: keluarga lokal, pendatang, mahasiswa, profesional, maupun jemaat lansia.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a
                        href="{{ route('kegiatan.index') }}"
                        class="inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                    >
                        Lihat Kegiatan Kami
                    </a>
                    <a
                        href="{{ route('kontak') }}"
                        class="inline-flex items-center justify-center rounded-full border border-line px-6 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                    >
                        Kunjungi Gereja
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Nilai Inti Iman --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                    Nilai-nilai yang kami hidupi
                </h2>
                <p class="mt-3 text-base leading-relaxed text-muted">
                    Prinsip dasar yang menuntun cara kami berpikir, melayani, dan membangun hubungan antar jemaat.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="text-xs font-bold text-accent dark:text-accent-soft">01</span>
                    <h3 class="mt-2 text-lg font-semibold text-ink">Kebenaran Firman</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Alkitab adalah pedoman tertinggi bagi iman, pengajaran, moral, dan keputusan hidup jemaat.
                    </p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="text-xs font-bold text-accent dark:text-accent-soft">02</span>
                    <h3 class="mt-2 text-lg font-semibold text-ink">Kasih yang Tulus</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Menerima sesama tanpa prasangka, rela mengampuni, dan saling menguatkan dalam perjalanan iman.
                    </p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="text-xs font-bold text-accent dark:text-accent-soft">03</span>
                    <h3 class="mt-2 text-lg font-semibold text-ink">Kerendahan Hati</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Melayani seperti Kristus yang membasuh kaki para murid, tanpa mencari pujian atau kedudukan diri.
                    </p>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-6">
                    <span class="text-xs font-bold text-accent dark:text-accent-soft">04</span>
                    <h3 class="mt-2 text-lg font-semibold text-ink">Integritas Hidup</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Kesesuaian antara apa yang diyakini, dikatakan, dan dilakukan dalam keluarga, pekerjaan, serta masyarakat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Pertanyaan yang Sering Diajukan (FAQ Pengunjung Baru) --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
                Pertanyaan seputar kunjungan pertama
            </h2>
            <p class="mt-3 text-base text-muted">
                Beberapa hal praktis yang kerap ditanyakan oleh jemaat atau tamu yang baru pertama kali hadir.
            </p>

            <div class="mt-8 space-y-4" x-data="{ active: null }">
                <div class="rounded-2xl border border-line bg-surface p-5">
                    <button
                        type="button"
                        @click="active = (active === 1 ? null : 1)"
                        class="flex w-full items-center justify-between text-left text-base font-semibold text-ink"
                    >
                        <span>Pakaian seperti apa yang disarankan untuk ibadah hari Minggu?</span>
                        <svg class="h-5 w-5 shrink-0 text-muted transition-transform duration-200" :class="active === 1 && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak class="mt-3 text-sm leading-relaxed text-muted">
                        Kami menyambut Anda dengan hangat dalam pakaian santai rapi, sopan, atau batik. Yang terpenting adalah hati yang rindu menyembah Tuhan.
                    </div>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-5">
                    <button
                        type="button"
                        @click="active = (active === 2 ? null : 2)"
                        class="flex w-full items-center justify-between text-left text-base font-semibold text-ink"
                    >
                        <span>Apakah ada ruangan dan ibadah khusus untuk anak-anak?</span>
                        <svg class="h-5 w-5 shrink-0 text-muted transition-transform duration-200" :class="active === 2 && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak class="mt-3 text-sm leading-relaxed text-muted">
                        Ya, kami menyediakan Sekolah Minggu yang berjalan bersamaan dengan Ibadah Raya pagi pukul 09.00 WITA. Ruang ramah anak didampingi oleh guru-guru yang penuh kasih dan terlatih.
                    </div>
                </div>

                <div class="rounded-2xl border border-line bg-surface p-5">
                    <button
                        type="button"
                        @click="active = (active === 3 ? null : 3)"
                        class="flex w-full items-center justify-between text-left text-base font-semibold text-ink"
                    >
                        <span>Bagaimana cara bergabung dalam kelompok sel atau persekutuan wilayah?</span>
                        <svg class="h-5 w-5 shrink-0 text-muted transition-transform duration-200" :class="active === 3 && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak class="mt-3 text-sm leading-relaxed text-muted">
                        Anda dapat menghubungi tim penyambut jemaat di meja informasi seusai ibadah, atau mengirim pesan melalui halaman Kontak. Kami akan menghubungkan Anda dengan koordinator wilayah terdekat tempat tinggal Anda.
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
