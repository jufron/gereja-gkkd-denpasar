@php
    $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
@endphp

<x-fe.layout.app
    title="Kebijakan Privasi — GKKD Denpasar"
    description="Kebijakan privasi GKKD Denpasar: data apa yang dikumpulkan, bagaimana digunakan, dan hak Anda."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-14 lg:pt-16 lg:pb-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                Informasi &amp; Privasi
            </span>
            <h1 class="mt-4 font-display text-4xl leading-[1.15] font-normal tracking-tight text-ink sm:text-5xl">
                Kebijakan Privasi
            </h1>
            <p class="mt-4 text-base leading-relaxed text-muted">
                Kami menghargai kepercayaan Anda. Halaman ini menjelaskan data yang kami kumpulkan dari layanan permohonan doa serta cara kami menjaganya.
            </p>
            <p class="mt-4 text-xs font-medium text-muted">Diperbarui: 3 November 2026</p>
        </div>
    </section>

    <section class="py-14 lg:py-20" data-reveal>
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div aria-hidden="true" class="pointer-events-none absolute -top-6 -right-4 -z-10 opacity-40">
                    <x-fe.prayer-illustration class="h-40 w-40 text-accent/20" />
                </div>

                <div class="space-y-10">
                    <div>
                        <h2 class="text-xl font-bold text-ink">1. Data yang kami kumpulkan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Saat Anda mengisi formulir permohonan doa, kami mengumpulkan:
                        </p>
                        <ul class="mt-3 list-inside list-disc space-y-1.5 text-sm text-muted">
                            <li>Nama lengkap</li>
                            <li>Jenis kelamin</li>
                            <li>Nomor HP</li>
                            <li>Alamat (opsional)</li>
                            <li>Kategori dan isi permohonan doa</li>
                            <li>Izin Anda untuk dihubungi</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">2. Data teknis</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Untuk mencegah penyalahgunaan formulir, kami mencatat alamat IP dan jenis peramban (user agent) secara otomatis. Data ini hanya digunakan untuk keamanan dan tidak dibagikan.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">3. Tujuan penggunaan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Seluruh data hanya digunakan untuk pelayanan doa dan tindak lanjut pastoral. Kami tidak menggunakan data ini untuk tujuan pemasaran atau periklanan.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">4. Akses dan kerahasiaan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Permohonan doa hanya dapat diakses oleh administrator dashboard gereja. Tidak ada daftar doa publik, dan data tidak pernah dibagikan kepada pihak ketiga.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">5. Penyimpanan dan penghapusan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Data disimpan selama diperlukan untuk pelayanan dan dihapus permanen oleh pengurus gereja setelah permohonan selesai ditindaklanjuti. Anda dapat meminta penghapusan lebih awal kapan saja.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">6. Hak Anda</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Anda berhak meminta salinan, koreksi, atau penghapusan data Anda kapan saja. Ajukan permintaan melalui halaman Kontak atau WhatsApp gereja, dan kami akan menindaklanjuti dalam waktu yang wajar.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">7. Cookie dan penyimpanan lokal</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Situs ini menggunakan cookie untuk sesi login (bagi pengurus) dan penyimpanan lokal untuk preferensi tema. Kami tidak menggunakan pelacak iklan atau alat analitik pihak ketiga.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">8. Perubahan kebijakan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Kebijakan ini dapat diperbarui sewaktu-waktu. Tanggal pembaruan terbaru selalu ditampilkan di bagian atas halaman ini.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-ink">9. Kontak</h2>
                        <p class="mt-3 text-sm leading-relaxed text-muted">
                            Untuk pertanyaan mengenai privasi atau data Anda, silakan hubungi kami melalui halaman
                            <a href="{{ route('kontak') }}" class="font-medium text-accent hover:underline dark:text-accent-soft">Kontak</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
