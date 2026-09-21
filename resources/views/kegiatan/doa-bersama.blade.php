<x-fe.layout.app
    title="Doa Bersama — GKKD Denpasar"
    description="Pertemuan doa dan syafaat mingguan setiap Rabu pukul 19.00 WITA di GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Kegiatan
                </a>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Ibadah Doa Bersama
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Doa orang benar bila dengan yakin didoakan sangat besar kuasanya. Mari bersatu hati merendahkan diri di hadapan Tuhan setiap Rabu malam.
                </p>
            </div>
        </div>
    </section>

    {{-- Jadwal & Fokus Doa --}}
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <div class="rounded-2xl border border-line bg-surface p-8">
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                            Jadwal Pertemuan Doa
                        </span>
                        <h2 class="mt-4 text-2xl font-bold text-ink">Setiap Rabu • Pukul 19.00 WITA</h2>
                        <p class="mt-3 text-base leading-relaxed text-muted">
                            Diadakan secara luring (tatap muka) di Ruang Doa Gereja dan terhubung melalui siaran daring bagi jemaat yang berhalangan hadir secara fisik.
                        </p>
                    </div>

                    <div class="mt-10">
                        <h3 class="text-xl font-semibold text-ink">Fokus Doa Syafaat Kami</h3>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl border border-line bg-ink/5 p-6">
                                <h4 class="font-semibold text-ink">1. Kota Denpasar dan Pulau Bali</h4>
                                <p class="mt-1 text-sm leading-relaxed text-muted">
                                    Memohon kedamaian, kerukunan antarumat beragama, kelancaran roda ekonomi pariwisata yang berkeadilan, serta perlindungan bagi seluruh warga.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-line bg-ink/5 p-6">
                                <h4 class="font-semibold text-ink">2. Pemulihan Keluarga & Kesembuhan</h4>
                                <p class="mt-1 text-sm leading-relaxed text-muted">
                                    Membawa nama-nama jemaat atau sanak saudara yang tengah berjuang melawan penyakit, depresi, atau perpecahan rumah tangga agar mengalami mujizat pemulihan.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-line bg-ink/5 p-6">
                                <h4 class="font-semibold text-ink">3. Generasi Muda & Anak-anak</h4>
                                <p class="mt-1 text-sm leading-relaxed text-muted">
                                    Mendoakan perlindungan moral dan iman bagi anak-anak serta kaum muda di tengah derasnya arus pengaruh modern.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Titip Pokok Doa --}}
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-line bg-surface p-6 shadow-sm sm:p-8">
                        <h3 class="text-xl font-semibold text-ink">Kirimkan Pokok Doa Anda</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">
                            Apakah Anda atau orang terkasih membutuhkan topangan doa? Tim doa kami akan mendoakan permohonan Anda secara rahasia dan bersungguh-sungguh.
                        </p>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label for="prayer_name" class="block text-sm font-medium text-ink">Nama Anda (boleh inisial)</label>
                                <input
                                    type="text"
                                    id="prayer_name"
                                    placeholder="Contoh: Maria / Anonim"
                                    class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                                >
                            </div>

                            <div>
                                <label for="prayer_request" class="block text-sm font-medium text-ink">Pokok Permohonan Doa</label>
                                <textarea
                                    id="prayer_request"
                                    rows="4"
                                    placeholder="Tuliskan pergumulan atau hal yang ingin kami doakan..."
                                    class="mt-1.5 w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                                ></textarea>
                            </div>

                            <a
                                href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom tim doa GKKD Denpasar, saya ingin menitipkan pokok doa: ') }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center rounded-full bg-accent py-3 text-center text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                            >
                                Kirim ke Tim Doa via WhatsApp
                            </a>
                            <p class="text-center text-xs text-muted">
                                Privasi Anda terjaga dan permohonan doa diperlakukan dengan penuh kerahasiaan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-fe.layout.app>
