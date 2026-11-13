<x-fe.layout.app
    title="Tim Multimedia — GKKD Denpasar"
    description="Tim Pelayanan Multimedia GKKD Denpasar: tata suara, cahaya, visual, livestream, dan dokumentasi ibadah."
>
    @php
        // Konten statis — perbarui label/URL kegiatan sesuai dokumentasi gereja.
        $activities = [
            ['label' => 'Live streaming ibadah minggu', 'd' => 'M2 6h20v12H2zM10 10l5 2.5-5 2.5V10z', 'img' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Sinematik & video profil', 'd' => 'M15 10l4.5-2.5v9L15 14M3 8h10a2 2 0 012 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4a2 2 0 012-2z', 'img' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Mixing sound system ibadah', 'd' => 'M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6', 'img' => 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Dokumentasi foto kegiatan', 'd' => 'M3 9a2 2 0 012-2h1.2a2 2 0 001.6-.8l.8-1.2A2 2 0 0110.2 4h3.6a2 2 0 011.6.8l.8 1.2a2 2 0 001.6.8H19a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM12 17a4 4 0 100-8 4 4 0 000 8z', 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Motion graphic & visual lirik', 'd' => 'M12 19l7-7 3 3-7 7-3-3zM18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5zM2 2l7.586 7.586', 'img' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Podcast & narasi renungan', 'd' => 'M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3zM19 10v2a7 7 0 01-14 0v-2M12 19v4M8 23h8', 'img' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?q=80&w=600&auto=format&fit=crop'],
            ['label' => 'Editing & color grading', 'd' => 'M4 6h16M4 12h16M4 18h10', 'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=600&auto=format&fit=crop'],
        ];
    @endphp

    {{-- Hero — tema terang --}}
    <section class="relative -mt-[var(--nav-h)] overflow-hidden pt-[var(--nav-h)]">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-accent/10 blur-3xl hero-float"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-accent/10 blur-3xl hero-float-slow"></div>

        <div class="relative mx-auto max-w-7xl px-4 pt-8 pb-14 text-center sm:px-6 md:pt-10 lg:px-8">
            <a href="{{ route('kegiatan.pelayanan') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted transition-colors hover:text-accent dark:hover:text-accent-soft" data-reveal>
                &larr; Kembali ke Pelayanan
            </a>

            <span class="mt-6 inline-flex items-center gap-2 rounded-full bg-surface ring-1 ring-line px-4 py-1.5 text-xs font-medium text-accent shadow-sm dark:text-accent-soft" data-reveal style="transition-delay:60ms">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 0l2.6 9.4L24 12l-9.4 2.6L12 24l-2.6-9.4L0 12l9.4-2.6L12 0z" />
                </svg>
                Melayani dengan hati & teknologi
            </span>

            <h1 class="mx-auto mt-6 max-w-3xl text-5xl font-semibold tracking-tight text-ink md:text-7xl" data-reveal style="transition-delay:140ms">
                Melayani di Balik <span class="text-accent dark:text-accent-soft">Layar</span> Ibadah
            </h1>

            <p class="mx-auto mt-6 max-w-xl text-sm leading-relaxed text-muted md:text-base" data-reveal style="transition-delay:220ms">
                Tim Pelayanan Multimedia adalah rekan kerja sunyi di balik setiap ibadah — mengatur suara,
                cahaya, visual, dan livestream agar firman Tuhan tersampaikan tanpa hambatan,
                dan setiap momen terdokumentasi dengan indah.
            </p>

            <div class="mt-9" data-reveal style="transition-delay:300ms">
                <a
                    href="https://wa.me/6281234567890?text={{ rawurlencode('Shalom, saya tertarik melayani di Tim Multimedia GKKD Denpasar.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-3 rounded-full bg-accent py-2.5 pl-3 pr-6 text-sm font-medium text-white shadow-lg shadow-accent/20 transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                >
                    <span class="grid h-7 w-7 place-items-center rounded-full bg-white/15">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    Gabung Tim Multimedia
                </a>
            </div>
        </div>
    </section>

    {{-- Strip kartu kegiatan (marquee) --}}
    <div class="marquee overflow-hidden border-y border-line py-6">
        <div class="marquee-track flex w-max gap-4 pl-4">
            @foreach ($activities as $index => $a)
                <div class="relative aspect-[7/10] w-44 shrink-0 overflow-hidden rounded-xl md:w-52" data-reveal style="transition-delay:{{ $index * 60 }}ms">
                    <img src="{{ $a['img'] }}" alt="{{ $a['label'] }}" class="h-full w-full object-cover" loading="lazy" width="416" height="594">
                    <span class="absolute top-2 right-2 left-2 flex items-center gap-1.5 rounded-full bg-black/60 px-2 py-1 ring-1 ring-white/20 backdrop-blur">
                        <span class="grid h-4 w-4 shrink-0 place-items-center rounded-full bg-white/15 text-white">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['d'] }}" />
                            </svg>
                        </span>
                        <span class="truncate text-[10px] font-medium text-white">{{ $a['label'] }}</span>
                    </span>
                </div>
            @endforeach

            {{-- Salinan kedua untuk loop mulus (aria-hidden supaya tidak dibaca dua kali) --}}
            @foreach ($activities as $a)
                <div class="relative aspect-[7/10] w-44 shrink-0 overflow-hidden rounded-xl md:w-52" aria-hidden="true">
                    <img src="{{ $a['img'] }}" alt="" class="h-full w-full object-cover" loading="lazy" width="416" height="594">
                    <span class="absolute top-2 right-2 left-2 flex items-center gap-1.5 rounded-full bg-black/60 px-2 py-1 ring-1 ring-white/20 backdrop-blur">
                        <span class="grid h-4 w-4 shrink-0 place-items-center rounded-full bg-white/15 text-white">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['d'] }}" />
                            </svg>
                        </span>
                        <span class="truncate text-[10px] font-medium text-white">{{ $a['label'] }}</span>
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tentang Tim --}}
    <section class="bg-surface py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-6" data-reveal>
                    <div class="aspect-[4/3] overflow-hidden rounded-3xl bg-ink/5">
                        <img
                            src="https://images.unsplash.com/photo-1478737270239-2f02b77fc618?q=80&w=1200&auto=format&fit=crop"
                            alt="Mixing desk tata suara ibadah"
                            class="h-full w-full object-cover ken-burns"
                            loading="lazy"
                            width="1200"
                            height="900"
                        >
                    </div>
                </div>
                <div class="lg:col-span-6" data-reveal style="transition-delay:100ms">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted">Tentang Tim</p>
                    <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight text-ink sm:text-4xl">
                        Bekerja dalam senyap,<br>agar ibadah berbicara.
                    </h2>
                    <p class="mt-5 text-base leading-relaxed text-muted">
                        Kami tidak berdiri di depan jemaat. Tugas kami memastikan setiap lirik terbaca,
                        setiap suara terdengar jernih, dan setiap momen terekam — tanpa ada yang perlu
                        memikirkan hal teknis.
                    </p>
                    <p class="mt-4 text-base leading-relaxed text-muted">
                        Di balik mixer, kamera, dan layar, ada tim yang berlatih, menyiapkan, dan berdoa
                        bersama sebelum ibadah dimulai.
                    </p>
                    <dl class="mt-8 grid grid-cols-3 gap-6 border-t border-line pt-6">
                        <div>
                            <dd class="font-display text-3xl font-normal text-accent dark:text-accent-soft">6</dd>
                            <dt class="mt-1 text-sm text-muted">Bidang teknis</dt>
                        </div>
                        <div>
                            <dd class="font-display text-3xl font-normal text-accent dark:text-accent-soft">4</dd>
                            <dt class="mt-1 text-sm text-muted">Tahap pelayanan</dt>
                        </div>
                        <div>
                            <dd class="font-display text-3xl font-normal text-accent dark:text-accent-soft">7</dd>
                            <dt class="mt-1 text-sm text-muted">Jenis kegiatan</dt>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    {{-- Bidang Pelayanan --}}
    <section class="bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted">Bidang Pelayanan</p>
                <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight text-ink sm:text-4xl">
                    Enam keahlian, satu alur ibadah.
                </h2>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['Audio & Sound System', 'Mengatur keseimbangan suara agar penyembahan dan firman terdengar jernih dari mimbar sampai barisan belakang.'],
                    ['Lighting & Atmosphere', 'Menata cahaya yang mengarahkan perhatian jemaat ke fokus ibadah tanpa mengganggu kenyamanan.'],
                    ['Livestream & Broadcasting', 'Menyiarkan ibadah secara langsung bagi jemaat yang hadir dari rumah, dengan kualitas gambar dan suara stabil.'],
                    ['Fotografi & Dokumentasi', 'Merekam setiap momen ibadah dan kegiatan gereja menjadi arsip yang dapat dikenang dan dibagikan.'],
                    ['Motion Graphic & Visual', 'Menyiapkan tayangan lirik, latar visual, dan grafis yang mendukung alur ibadah.'],
                    ['IT & Tata Ibadah', 'Memastikan perangkat, proyektor, dan jaringan berjalan andal dari persiapan hingga acara selesai.'],
                ] as $index => $skill)
                    <div class="group rounded-3xl border border-line bg-surface p-6 transition-all duration-300 hover:-translate-y-1 hover:border-accent/40 hover:shadow-md" data-reveal style="transition-delay:{{ $index * 60 }}ms">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent transition-colors group-hover:bg-accent group-hover:text-white dark:text-accent-soft">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                @if ($index === 0)
                                    <path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6" />
                                @elseif ($index === 1)
                                    <path d="M2 13h4l3-8 4 14 3-6h6" />
                                @elseif ($index === 2)
                                    <path d="M2 6h20v12H2zM10 10l5 2.5-5 2.5V10z" />
                                @elseif ($index === 3)
                                    <path d="M3 9a2 2 0 012-2h1.2a2 2 0 001.6-.8l.8-1.2A2 2 0 0110.2 4h3.6a2 2 0 011.6.8l.8 1.2a2 2 0 001.6.8H19a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM12 17a4 4 0 100-8 4 4 0 000 8z" />
                                @elseif ($index === 4)
                                    <path d="M12 19l7-7 3 3-7 7-3-3zM18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5zM2 2l7.586 7.586" />
                                @else
                                    <rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 2v4M15 2v4M2 9h20" />
                                @endif
                            </svg>
                        </span>
                        <h3 class="mt-5 text-lg font-semibold text-ink">{{ $skill[0] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $skill[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Alur Pelayanan --}}
    <section class="bg-surface py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted">Alur Pelayanan</p>
                <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight text-ink sm:text-4xl">
                    Dari rundown sampai evaluasi.
                </h2>
            </div>
            <ol class="mt-10 grid gap-6 md:grid-cols-4">
                @foreach ([
                    ['01', 'Persiapan', 'Membaca rundown, membagi tugas, dan memastikan semua kebutuhan teknis siap sebelum ibadah.'],
                    ['02', 'Setup', 'Memasang dan menguji perangkat audio, visual, dan streaming jauh sebelum jemaat hadir.'],
                    ['03', 'Pelaksanaan', 'Menjalankan tata suara, cahaya, tayangan, dan siaran mengikuti alur ibadah.'],
                    ['04', 'Evaluasi', 'Mengumpulkan masukan dan merapikan perangkat agar minggu berikutnya lebih baik.'],
                ] as $step)
                    <li class="rounded-3xl border border-line bg-surface p-6" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <span class="font-display text-4xl font-normal text-accent dark:text-accent-soft">{{ $step[0] }}</span>
                        <h3 class="mt-4 text-base font-semibold text-ink">{{ $step[1] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $step[2] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Galeri Behind the Scenes --}}
    <section class="bg-ink/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted">Galeri</p>
                <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight text-ink sm:text-4xl">
                    Sisi yang jarang terlihat.
                </h2>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=800&auto=format&fit=crop', 'Konser dan panggung dengan sorot lampu'],
                    ['https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?q=80&w=800&auto=format&fit=crop', 'Kamera dan peralatan sinematik'],
                    ['https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=800&auto=format&fit=crop', 'Operator multimedia di panel kendali'],
                    ['https://images.unsplash.com/photo-1590602847861-f357a9332bbc?q=80&w=800&auto=format&fit=crop', 'Mikrofon studio untuk podcast'],
                    ['https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800&auto=format&fit=crop', 'Tim bekerja dengan laptop dan perangkat'],
                    ['https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop', 'Suasana kolaborasi tim kreatif'],
                ] as $index => $photo)
                    <figure class="group relative aspect-[4/5] overflow-hidden rounded-3xl bg-ink/5" data-reveal style="transition-delay:{{ $index * 60 }}ms">
                        <img
                            src="{{ $photo[0] }}"
                            alt="{{ $photo[1] }}"
                            class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 motion-reduce:transform-none"
                            loading="lazy"
                            width="800"
                            height="1000"
                        >
                        <figcaption class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent px-5 pt-16 pb-4 text-sm font-medium text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100 motion-reduce:opacity-100">
                            {{ $photo[1] }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Nilai Tim --}}
    <section class="bg-surface py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted">Nilai Tim</p>
                <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight text-ink sm:text-4xl">
                    Tiga hal yang kami jaga.
                </h2>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['01', 'Rapi', 'Setiap kabel, perangkat, dan file memiliki tempatnya. Kerapian menjaga ibadah tetap fokus.'],
                    ['02', 'Sigap', 'Ketika terjadi kendala, kami bergerak cepat tanpa membuat jemaat khawatir.'],
                    ['03', 'Rendah Hati', 'Kami melayani untuk kemuliaan Tuhan, bukan untuk dilihat orang.'],
                ] as $value)
                    <div class="rounded-3xl border border-line bg-surface p-6" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <span class="font-display text-5xl font-normal text-accent/20 dark:text-accent-soft/20">{{ $value[0] }}</span>
                        <h3 class="mt-3 text-lg font-semibold text-ink">{{ $value[1] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $value[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Mendukung setiap pelayanan gereja --}}
    <section class="border-t border-line bg-ink/5 px-6 py-12 text-center">
        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-muted" data-reveal>
            Mendukung setiap pelayanan gereja
        </p>
        <div class="mx-auto mt-7 flex max-w-4xl flex-wrap items-center justify-center gap-x-10 gap-y-4 text-muted" data-reveal style="transition-delay:80ms">
            <span class="text-sm font-bold text-ink">Ibadah Minggu</span>
            <span class="text-sm font-semibold italic">Praise &amp; Worship</span>
            <span class="text-sm font-extrabold tracking-widest text-ink uppercase">Sekolah Minggu</span>
            <span class="text-sm font-semibold">Youth Night</span>
            <span class="text-sm font-bold italic">Diakonia</span>
            <span class="text-sm font-extrabold tracking-tight text-ink">Keluarga</span>
        </div>
    </section>

    @push('head')
        <style>
            @keyframes marquee {
                from { transform: translateX(0); }
                to { transform: translateX(-50%); }
            }
            .marquee-track {
                animation: marquee 45s linear infinite;
            }
            .marquee:hover .marquee-track,
            .marquee:focus-within .marquee-track {
                animation-play-state: paused;
            }
            @media (prefers-reduced-motion: reduce) {
                .marquee-track {
                    animation: none;
                }
                .marquee {
                    overflow-x: auto;
                }
            }
        </style>
    @endpush
</x-fe.layout.app>
