<x-fe.layout.app
    title="Galeri Dokumentasi — GKKD Denpasar"
    description="Potret kebersamaan jemaat, perayaan ibadah, pendidikan anak, dan bakti sosial GKKD Denpasar di Bali."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Dokumentasi Pelayanan
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Rekam Jejak Kasih dan Kebersamaan
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Setiap momen persekutuan, senyuman anak-anak, dan uluran tangan kasih adalah wujud syukur kami atas anugerah Allah di Bali.
                </p>
            </div>
        </div>
    </section>

    {{-- Galeri Foto Masonry / Pinterest Style dengan Filter Alpine.js --}}
    <section class="py-16 lg:py-24" x-data="{
        category: 'all',
        activeImage: null,
        activeTitle: '',
        activeDesc: '',
        openModal(src, title, desc) {
            this.activeImage = src;
            this.activeTitle = title;
            this.activeDesc = desc;
        },
        closeModal() {
            this.activeImage = null;
        }
    }" @keydown.escape.window="closeModal()">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    @click="category = 'all'"
                    :class="category === 'all' ? 'bg-accent text-white' : 'bg-surface border border-line text-ink hover:border-accent'"
                    class="rounded-full px-4 py-2 text-xs font-medium transition-colors"
                >
                    Semua Foto
                </button>
                <button
                    type="button"
                    @click="category = 'ibadah'"
                    :class="category === 'ibadah' ? 'bg-accent text-white' : 'bg-surface border border-line text-ink hover:border-accent'"
                    class="rounded-full px-4 py-2 text-xs font-medium transition-colors"
                >
                    Ibadah Raya
                </button>
                <button
                    type="button"
                    @click="category = 'komunitas'"
                    :class="category === 'komunitas' ? 'bg-accent text-white' : 'bg-surface border border-line text-ink hover:border-accent'"
                    class="rounded-full px-4 py-2 text-xs font-medium transition-colors"
                >
                    Komunitas &amp; Fellowship
                </button>
                <button
                    type="button"
                    @click="category = 'anak'"
                    :class="category === 'anak' ? 'bg-accent text-white' : 'bg-surface border border-line text-ink hover:border-accent'"
                    class="rounded-full px-4 py-2 text-xs font-medium transition-colors"
                >
                    Sekolah Minggu
                </button>
                <button
                    type="button"
                    @click="category = 'sosial'"
                    :class="category === 'sosial' ? 'bg-accent text-white' : 'bg-surface border border-line text-ink hover:border-accent'"
                    class="rounded-full px-4 py-2 text-xs font-medium transition-colors"
                >
                    Bakti Sosial
                </button>
            </div>

            {{-- Pinterest / Masonry Layout (CSS Columns) --}}
            <div class="mt-10 columns-1 gap-6 space-y-6 sm:columns-2 lg:columns-3 xl:columns-4">
                
                {{-- Item 1: Tall / Potret Ibadah --}}
                <div
                    x-show="category === 'all' || category === 'ibadah'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('{{ asset('images/church-sanctuary.jpg') }}', 'Suasana Ibadah Raya GKKD Denpasar', 'Pujian dan penyembahan yang intim di ruang ibadah utama gereja.')"
                >
                    <div class="aspect-3/4 overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/church-sanctuary.jpg') }}"
                            alt="Suasana Ibadah Raya GKKD Denpasar"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Ibadah Raya</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Sanctuary GKKD Denpasar</h3>
                        <p class="mt-1 text-xs text-muted">Momen pujian dan persekutuan bersama seluruh jemaat.</p>
                    </div>
                </div>

                {{-- Item 2: Landscape / Komunitas --}}
                <div
                    x-show="category === 'all' || category === 'komunitas'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('{{ asset('images/fellowship.jpg') }}', 'Persekutuan Komunitas Sel', 'Suasana hangat kebersamaan jemaat seusai ibadah dan di kelompok sel.')"
                >
                    <div class="aspect-16/10 overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/fellowship.jpg') }}"
                            alt="Persekutuan Komunitas Sel"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Komunitas &amp; Fellowship</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Keakraban di Pelataran Gereja</h3>
                        <p class="mt-1 text-xs text-muted">Berbagi cerita dan kehangatan persaudaraan seiman.</p>
                    </div>
                </div>

                {{-- Item 3: Square / Sekolah Minggu --}}
                <div
                    x-show="category === 'all' || category === 'anak'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('{{ asset('images/sunday-school.jpg') }}', 'Aktivitas Ceria Sekolah Minggu', 'Anak-anak belajar nilai kasih dan kebenaran Alkitab melalui musik dan karya tangan.')"
                >
                    <div class="aspect-square overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/sunday-school.jpg') }}"
                            alt="Aktivitas Ceria Sekolah Minggu"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Sekolah Minggu</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Keceriaan Anak-Anak di Kelas</h3>
                        <p class="mt-1 text-xs text-muted">Mengenal firman Tuhan dengan gembira dan kreatif.</p>
                    </div>
                </div>

                {{-- Item 4: Tall / Bakti Sosial --}}
                <div
                    x-show="category === 'all' || category === 'sosial'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('{{ asset('images/outreach.jpg') }}', 'Penyaluran Paket Kasih Bagi Warga', 'Bakti sosial dan pembagian perlengkapan belajar bagi anak-anak di Bali.')"
                >
                    <div class="aspect-3/5 overflow-hidden bg-ink/5">
                        <img
                            src="{{ asset('images/outreach.jpg') }}"
                            alt="Bakti Sosial di Bali"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Bakti Sosial</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Aksi Kasih Bagi Sesama di Bali</h3>
                        <p class="mt-1 text-xs text-muted">Menyentuh kebutuhan riil masyarakat dengan ketulusan.</p>
                    </div>
                </div>

                {{-- Item 5: Placeholder Potret Tambahan --}}
                <div
                    x-show="category === 'all' || category === 'ibadah'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('https://picsum.photos/seed/church-praise/600/800', 'Pujian dan Penyembahan', 'Momen keintiman jemaat menyembah Tuhan.')"
                >
                    <div class="aspect-3/4 overflow-hidden bg-ink/5">
                        <img
                            src="https://picsum.photos/seed/church-praise/600/800"
                            alt="Pujian dan Penyembahan"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Ibadah Raya</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Tim Musik &amp; Singer</h3>
                        <p class="mt-1 text-xs text-muted">Melayani hadirat Tuhan dengan ketulusan hati.</p>
                    </div>
                </div>

                {{-- Item 6: Placeholder Landscape Tambahan --}}
                <div
                    x-show="category === 'all' || category === 'komunitas'"
                    x-transition
                    class="group relative cursor-pointer break-inside-avoid overflow-hidden rounded-2xl border border-line bg-surface shadow-xs transition-all hover:border-accent/40 hover:shadow-md"
                    @click="openModal('https://picsum.photos/seed/fellowship-group/800/500', 'Kelompok Sel Persekutuan Wilayah', 'Belajar Alkitab dan berdoa bersama di rumah jemaat.')"
                >
                    <div class="aspect-16/10 overflow-hidden bg-ink/5">
                        <img
                            src="https://picsum.photos/seed/fellowship-group/800/500"
                            alt="Persekutuan Wilayah"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                    <div class="p-4">
                        <span class="text-[11px] font-semibold text-accent dark:text-accent-soft">Komunitas &amp; Fellowship</span>
                        <h3 class="mt-1 text-sm font-semibold text-ink">Kelompok Sel Renon</h3>
                        <p class="mt-1 text-xs text-muted">Saling menguatkan dalam persekutuan kelompok kecil.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Lightbox Modal --}}
        <div
            x-show="activeImage"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm"
            @click="closeModal()"
        >
            <div
                class="relative max-w-4xl overflow-hidden rounded-2xl bg-surface shadow-2xl"
                @click.stop
            >
                <button
                    type="button"
                    @click="closeModal()"
                    class="absolute top-4 right-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/60 text-white hover:bg-black"
                >
                    <span class="sr-only">Tutup</span>
                    &times;
                </button>
                <img :src="activeImage" :alt="activeTitle" class="max-h-[75vh] w-full object-contain">
                <div class="p-5 sm:p-6">
                    <h3 class="text-lg font-semibold text-ink" x-text="activeTitle"></h3>
                    <p class="mt-1 text-sm text-muted" x-text="activeDesc"></p>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
