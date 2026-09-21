<x-fe.layout.app
    title="Kontak & Lokasi — GKKD Denpasar"
    description="Alamat gereja, nomor kontak WhatsApp, jadwal kantor pastoral, dan formulir pesan GKKD Denpasar, Bali."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Layanan & Konseling
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Hubungi dan Kunjungi Kami
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Pintu kami selalu terbuka untuk Anda. Baik Anda ingin bertanya seputar ibadah, membutuhkan doa, atau konseling pastoral, kami siap menyambut Anda.
                </p>
            </div>
        </div>
    </section>

    {{-- Section 1: 2 Kolom (Informasi Gereja & Google Maps Embed) --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-12 items-start">
                
                {{-- Kolom Kiri (5 Columns): Informasi Gereja --}}
                <div class="lg:col-span-5">
                    <h2 class="text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                        Informasi Gereja
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Silakan hubungi kami melalui saluran komunikasi berikut atau datang langsung ke lokasi sekretariat gereja.
                    </p>

                    <div class="mt-8 space-y-6">
                        {{-- Alamat --}}
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-ink">Lokasi Gereja</h3>
                                <p class="mt-1 text-sm leading-relaxed text-muted">
                                    Jl. Teuku Umar No. 120, Denpasar Barat,<br>
                                    Kota Denpasar, Bali 80113
                                </p>
                                <a
                                    href="https://maps.google.com/?q=Denpasar+Bali"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-2 inline-flex items-center text-xs font-semibold text-accent hover:underline dark:text-accent-soft"
                                >
                                    Buka di Aplikasi Google Maps &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- WhatsApp & Telepon --}}
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-ink">Layanan WhatsApp & Konseling</h3>
                                <p class="mt-1 text-sm text-muted">+62 812-3456-7890 (Pastoral Care)</p>
                                <a
                                    href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-2 inline-flex items-center text-xs font-semibold text-accent hover:underline dark:text-accent-soft"
                                >
                                    Kirim Pesan WhatsApp Sekarang &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- Jam Layanan Kantor --}}
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-ink">Waktu Operasional Kantor</h3>
                                <p class="mt-1 text-sm text-muted">Selasa – Sabtu: 09.00 – 17.00 WITA</p>
                                <p class="text-sm text-muted">Minggu: 08.00 – 19.30 WITA</p>
                                <p class="text-xs text-muted/70">Senin: Libur pastoral</p>
                            </div>
                        </div>
                    </div>

                    {{-- Panduan Parkir & Akses --}}
                    <div class="mt-8 rounded-2xl border border-line bg-surface p-5">
                        <h4 class="text-sm font-semibold text-ink">Akses Kendaraan & Parkir</h4>
                        <p class="mt-1 text-xs leading-relaxed text-muted">
                            Area parkir mobil dan sepeda motor tersedia di pelataran gereja dengan petugas keamanan yang memandu jemaat saat datang dan keluar ibadah.
                        </p>
                    </div>
                </div>

                {{-- Kolom Kanan (7 Columns): Google Maps Embed --}}
                <div class="lg:col-span-7">
                    <div class="overflow-hidden rounded-3xl border border-line bg-surface shadow-md">
                        <div class="p-5 border-b border-line flex items-center justify-between">
                            <h3 class="text-base font-bold text-ink">Peta Lokasi Google Maps</h3>
                            <span class="text-xs text-muted">Denpasar Barat, Bali</span>
                        </div>
                        <div class="h-[420px] w-full sm:h-[480px]">
                            <iframe
                                class="h-full w-full border-0"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.2706346214554!2d115.2072!3d-8.6731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e0a6d%3A0x1c80d463b2f5421!2sDenpasar%2C%20Bali!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Lokasi Google Maps GKKD Denpasar"
                            ></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Section 2: Kirim Pesan / Formulir Permohonan (Paling Bawah) --}}
    <section class="border-t border-line bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-line bg-surface p-6 sm:p-10 shadow-sm">
                <div class="max-w-xl">
                    <h2 class="text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                        Kirim Pesan atau Permohonan
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Isi formulir di bawah ini dan tim pelayanan kami akan merespons dalam waktu 1x24 jam kerja.
                    </p>
                </div>

                <form
                    action="#"
                    method="POST"
                    class="mt-8 space-y-6"
                    x-data="{ submitted: false }"
                    @submit.prevent="submitted = true"
                >
                    @csrf

                    <div x-show="submitted" x-cloak class="rounded-2xl border border-accent/20 bg-accent/10 p-5 text-ink">
                        <h4 class="font-semibold text-accent dark:text-accent-soft">Terima kasih atas pesan Anda!</h4>
                        <p class="mt-1 text-sm text-muted">Pesan Anda telah kami terima. Tim pastoral kami akan segera menghubungi Anda kembali.</p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2" x-show="!submitted">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-ink">Nama Lengkap</label>
                            <input
                                type="text"
                                id="contact_name"
                                name="name"
                                required
                                placeholder="Contoh: Stefanus Bagus"
                                class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                            >
                            <span class="mt-1 block text-xs text-muted">Nama Anda atau perwakilan keluarga.</span>
                        </div>

                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-ink">Nomor Telepon / WhatsApp</label>
                            <input
                                type="tel"
                                id="contact_phone"
                                name="phone"
                                required
                                placeholder="0812xxxxxxxx"
                                class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                            >
                            <span class="mt-1 block text-xs text-muted">Aktif untuk WhatsApp mempermudah konfirmasi.</span>
                        </div>
                    </div>

                    <div x-show="!submitted">
                        <label for="contact_subject" class="block text-sm font-medium text-ink">Tujuan Pesan</label>
                        <select
                            id="contact_subject"
                            name="subject"
                            class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                        >
                            <option value="pertanyaan_ibadah">Pertanyaan Seputar Ibadah Minggu</option>
                            <option value="persekutuan_wilayah">Pendaftaran Persekutuan Wilayah / Kelompok Sel</option>
                            <option value="konseling_pastoral">Permohonan Konseling Pastoral</option>
                            <option value="sekolah_minggu">Informasi Kelas Anak Sekolah Minggu</option>
                            <option value="lainnya">Hal Lainnya</option>
                        </select>
                    </div>

                    <div x-show="!submitted">
                        <label for="contact_message" class="block text-sm font-medium text-ink">Isi Pesan atau Kebutuhan</label>
                        <textarea
                            id="contact_message"
                            name="message"
                            rows="5"
                            required
                            placeholder="Ceritakan pertanyaan atau kebutuhan pelayanan Anda..."
                            class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                        ></textarea>
                        <span class="mt-1 block text-xs text-muted">Informasi Anda dijaga kerahasiaannya oleh tim pastoral.</span>
                    </div>

                    <div x-show="!submitted" class="flex items-center justify-between pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3 text-sm font-medium text-white transition-all hover:bg-accent-strong active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                        >
                            Kirim Pesan
                        </button>
                        <span class="text-xs text-muted">Atau hubungi kami langsung via WhatsApp</span>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-fe.layout.app>
