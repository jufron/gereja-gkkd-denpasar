<x-fe.layout.app
    title="Detail Khotbah — GKKD Denpasar"
    description="Rangkuman dan khotbah lengkap beserta materi slide PPT dan rekaman ibadah GKKD Denpasar."
>
    @php
        $khotbahData = [
            'hidup-dalam-kasih-karunia-yang-cukup' => [
                'title' => 'Hidup dalam Kasih Karunia yang Cukup',
                'speaker' => 'Pdt. Samuel Wijaya',
                'speaker_title' => 'Gembala Sidang GKKD Denpasar',
                'speaker_photo' => 'https://picsum.photos/seed/pastor-samuel/120/120',
                'passage' => '2 Korintus 12:7–10',
                'date' => 'Minggu, 21 September 2025',
                'service' => 'Ibadah Raya Minggu Pagi (09.00 WITA)',
                'location' => 'Gedung Utama GKKD Denpasar',
                'summary' => 'Paulus mengajarkan bahwa kelemahan bukan penghalang, melainkan ruang di mana kuasa Kristus dinyatakan dengan nyata. Kasih karunia Tuhan selalu cukup untuk menanggung setiap beban kehidupan kita sehari-hari.',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder ID
                'ppt_link' => '#',
                'content' => [
                    'Poin 1: Mengakui Kelemahan Kita di Hadapan Tuhan' => 'Dalam hidup, seringkali kita mencoba menyembunyikan keterbatasan dan kelemahan diri. Namun Paulus mengingatkan bahwa pengakuan akan keterbatasan adalah awal dari masuknya kuasa dan rahmat Tuhan yang memulihkan.',
                    'Poin 2: Kasih Karunia yang Lebih dari Cukup' => 'Tuhan tidak selalu mencabut duri dalam daging atau kesulitan hidup kita, namun Ia memberikan kasih karunia dan ketabahan ekstra sehingga kita mampu melewati setiap pergumulan dengan kemenangan.',
                    'Poin 3: Kuasa Kristus Sempurna dalam Kelemahan' => 'Saat kita sadar tidak mampu mengandalkan kekuatan sendiri, di situlah kita sepenuhnya bergantung kepada Roh Kudus. Sikap penyerahan penuh inilah yang memancarkan kemuliaan Tuhan dalam hidup jemaat.'
                ]
            ],
            'mengikut-yesus-dengan-sepenuh-hati' => [
                'title' => 'Mengikut Yesus dengan Sepenuh Hati',
                'speaker' => 'Pdt. Maria Santoso',
                'speaker_title' => 'Hamba Tuhan GKKD Denpasar',
                'speaker_photo' => 'https://picsum.photos/seed/pastor-maria/120/120',
                'passage' => 'Lukas 9:23–25',
                'date' => 'Minggu, 14 September 2025',
                'service' => 'Ibadah Raya Minggu Sore (17.00 WITA)',
                'location' => 'Gedung Utama GKKD Denpasar',
                'summary' => 'Panggilan menyangkal diri dan memikul salib bukan sebuah beban, melainkan undangan untuk menemukan kehidupan yang sesungguhnya bersama Kristus setiap hari.',
                'youtube_id' => null,
                'ppt_link' => '#',
                'content' => [
                    'Poin 1: Menyangkal Diri Setiap Hari' => 'Menyangkal diri berarti mengutamakan kehendak Tuhan di atas kehendak pribadi dan ego kita.',
                    'Poin 2: Memikul Salib dengan Sukacita' => 'Salib mewakili kesetiaan mengikut Yesus meskipun menghadapi tantangan dan konsekuensi di tengah dunia.',
                    'Poin 3: Memperoleh Kehidupan Sejati' => 'Barangsiapa kehilangan nyawanya karena Kristus, ia akan memperoleh kehidupan kekal yang penuh kelimpahan sukacita.'
                ]
            ],
            'doa-yang-mengubah-keadaan' => [
                'title' => 'Doa yang Mengubah Keadaan',
                'speaker' => 'Ev. Yohanes Pratama',
                'speaker_title' => 'Tim Pelayanan Doa',
                'speaker_photo' => 'https://picsum.photos/seed/evangelist-yohanes/120/120',
                'passage' => 'Yakobus 5:13–16',
                'date' => 'Rabu, 10 September 2025',
                'service' => 'Ibadah Doa Bersama (19.00 WITA)',
                'location' => 'Ruang Konseling & Online Zoom',
                'summary' => 'Doa orang benar sangat besar kuasanya. Saat jemaat berdoa bersama dengan iman, Tuhan bergerak memulihkan, menyembuhkan, dan mengubah situasi yang tampak mustahil.',
                'youtube_id' => 'dQw4w9WgXcQ',
                'ppt_link' => null,
                'content' => [
                    'Poin 1: Doa yang Lahir dari Iman' => 'Kekuatan doa tidak terletak pada panjangnya kata-kata, melainkan pada ketulusan iman kepada Allah yang maha kuasa.',
                    'Poin 2: Kuasa Doa Syafaat Bersama' => 'Ketika jemaat sepakat dalam doa bersama, ada pengurapan dan kekuatan khusus yang dicurahkan atas gereja dan kota.',
                    'Poin 3: Keterbukaan dan Saling Mendoakan' => 'Saling mengaku dosa dan saling mendoakan membawa kesembuhan rohani maupun jasmani bagi komunitas beriman.'
                ]
            ]
        ];

        $detail = $khotbahData[$slug] ?? $khotbahData['hidup-dalam-kasih-karunia-yang-cukup'];
    @endphp

    {{-- Header / Breadcrumb --}}
    <section class="border-b border-line bg-ink/5 pt-10 pb-12 lg:pt-14 lg:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Rangkuman Khotbah
                </a>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        {{ $detail['service'] }}
                    </span>
                    <span class="text-xs text-muted">&bull; {{ $detail['date'] }}</span>
                </div>
                <h1 class="mt-3 text-3xl leading-tight font-semibold tracking-tight text-ink sm:text-4xl lg:text-5xl">
                    {{ $detail['title'] }}
                </h1>
                <div class="mt-4 flex items-center gap-3">
                    <img src="{{ $detail['speaker_photo'] }}" alt="{{ $detail['speaker'] }}" class="h-12 w-12 rounded-full object-cover ring-2 ring-line">
                    <div>
                        <p class="text-base font-semibold text-ink">{{ $detail['speaker'] }}</p>
                        <p class="text-xs text-muted">{{ $detail['speaker_title'] }} &bull; Ayat: <span class="font-medium text-ink">{{ $detail['passage'] }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Detail --}}
    <section class="py-12 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                
                {{-- Left Side: Rincian Khotbah & Media --}}
                <div class="lg:col-span-8">
                    
                    {{-- Rekaman Video (jika ada) --}}
                    @if($detail['youtube_id'])
                        <div class="mb-10 overflow-hidden rounded-2xl border border-line bg-surface shadow-sm">
                            <div class="aspect-video w-full">
                                <iframe
                                    class="h-full w-full"
                                    src="https://www.youtube.com/embed/{{ $detail['youtube_id'] }}"
                                    title="Rekaman Khotbah {{ $detail['title'] }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    @endif

                    {{-- Ringkasan Utama --}}
                    <div class="rounded-2xl border border-line bg-surface p-6 sm:p-8">
                        <h2 class="text-xl font-bold text-ink sm:text-2xl">Ringkasan & Inti Pesan</h2>
                        <p class="mt-4 text-base leading-relaxed text-muted">
                            {{ $detail['summary'] }}
                        </p>

                        <hr class="my-8 border-line">

                        {{-- Poin-poin Pembahasan Khotbah --}}
                        <h3 class="text-lg font-semibold text-ink">Poin-poin Rincian Khotbah:</h3>
                        <div class="mt-6 space-y-6">
                            @foreach($detail['content'] as $poin => $penjelasan)
                                <div class="rounded-xl border border-line bg-ink/5 p-5">
                                    <h4 class="font-semibold text-ink sm:text-lg">{{ $poin }}</h4>
                                    <p class="mt-2 text-sm leading-relaxed text-muted sm:text-base">
                                        {{ $penjelasan }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right Side: Informasi & Download Slide --}}
                <div class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">
                        
                        {{-- Information Card --}}
                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <h3 class="text-base font-semibold text-ink">Informasi Ibadah</h3>
                            <dl class="mt-4 space-y-4 text-sm divide-y divide-line">
                                <div class="pt-2">
                                    <dt class="text-xs text-muted">Tanggal Khotbah</dt>
                                    <dd class="mt-1 font-medium text-ink">{{ $detail['date'] }}</dd>
                                </div>
                                <div class="pt-3">
                                    <dt class="text-xs text-muted">Sesi Ibadah</dt>
                                    <dd class="mt-1 font-medium text-ink">{{ $detail['service'] }}</dd>
                                </div>
                                <div class="pt-3">
                                    <dt class="text-xs text-muted">Ayat Referensi Utama</dt>
                                    <dd class="mt-1 font-medium text-accent dark:text-accent-soft">{{ $detail['passage'] }}</dd>
                                </div>
                                <div class="pt-3">
                                    <dt class="text-xs text-muted">Lokasi</dt>
                                    <dd class="mt-1 font-medium text-ink">{{ $detail['location'] }}</dd>
                                </div>
                            </dl>

                            {{-- Actions / Material Download --}}
                            <div class="mt-6 border-t border-line pt-4 space-y-3">
                                @if($detail['ppt_link'])
                                    <a
                                        href="{{ $detail['ppt_link'] }}"
                                        download
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent py-3 text-center text-sm font-semibold text-white transition-colors hover:bg-accent-strong"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4 shrink-0">
                                            <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                            <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                        </svg>
                                        Unduh Slide Presentation (PPT)
                                    </a>
                                @else
                                    <button disabled class="w-full rounded-full border border-line py-3 text-center text-sm font-medium text-muted/60 bg-ink/5 cursor-not-allowed">
                                        Slide PPT Belum Tersedia
                                    </button>
                                @endif

                                <a
                                    href="{{ route('kegiatan.index') }}"
                                    class="inline-flex w-full items-center justify-center rounded-full border border-line py-3 text-center text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft"
                                >
                                    Lihat Khotbah Lainnya
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</x-fe.layout.app>
