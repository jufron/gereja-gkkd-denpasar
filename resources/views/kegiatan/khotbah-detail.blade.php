<x-fe.layout.app
    title="{{ $sermon->title }} — GKKD Denpasar"
    description="Rangkuman khotbah {{ $sermon->title }} oleh {{ $sermon->preacher }} GKKD Denpasar."
>
    {{-- Header / Breadcrumb --}}
    <section class="border-b border-line bg-ink/5 pt-10 pb-12 lg:pt-14 lg:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Rangkuman Khotbah
                </a>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                        {{ $sermon->preached_at->translatedFormat('d F Y') }}
                    </span>
                    @if ($sermon->location)
                        <span class="text-xs text-muted">&bull; {{ $sermon->location }}</span>
                    @endif
                </div>
                <h1 class="mt-3 text-3xl leading-tight font-semibold tracking-tight text-ink sm:text-4xl lg:text-5xl">
                    {{ $sermon->title }}
                </h1>
                <div class="mt-4 flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-tr from-accent-strong to-accent text-base font-bold text-white ring-2 ring-line">
                        {{ $sermon->preacher_initials }}
                    </span>
                    <div>
                        <p class="text-base font-semibold text-ink">{{ $sermon->preacher }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">

                {{-- Left: Pembahasan --}}
                <div class="lg:col-span-8">
                    <div class="rounded-2xl border border-line bg-surface p-6 sm:p-8">
                        <h2 class="text-xl font-bold text-ink sm:text-2xl">Pembahasan Khotbah</h2>
                        <div class="berita-content mt-6">
                            {!! $sermon->content !!}
                        </div>
                    </div>
                </div>

                {{-- Right: Informasi & Materi --}}
                <div class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">

                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <h3 class="text-base font-semibold text-ink">Informasi Ibadah</h3>
                            <dl class="mt-4 space-y-4 text-sm divide-y divide-line">
                                <div class="pt-2">
                                    <dt class="text-xs text-muted">Tanggal Khotbah</dt>
                                    <dd class="mt-1 font-medium text-ink">{{ $sermon->preached_at->translatedFormat('l, d F Y') }}</dd>
                                </div>
                                @if ($sermon->location)
                                    <div class="pt-3">
                                        <dt class="text-xs text-muted">Lokasi</dt>
                                        <dd class="mt-1 font-medium text-ink">{{ $sermon->location }}</dd>
                                    </div>
                                @endif
                            </dl>

                            <div class="mt-6 border-t border-line pt-4 space-y-3">
                                @if ($sermon->ppt_url)
                                    <a
                                        href="{{ $sermon->ppt_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent py-3 text-center text-sm font-semibold text-white transition-colors hover:bg-accent-strong"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4 shrink-0">
                                            <path d="M2.75 14a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H2.75Z"/>
                                            <path fill-rule="evenodd" d="M8 1.5a.75.75 0 0 1 .75.75v6.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 0 1 1.06-1.06l2.22 2.22V2.25A.75.75 0 0 1 8 1.5Z" clip-rule="evenodd"/>
                                        </svg>
                                        Unduh Materi (PPT)
                                    </a>
                                @else
                                    <button disabled class="w-full rounded-full border border-line py-3 text-center text-sm font-medium text-muted/60 bg-ink/5 cursor-not-allowed">
                                        Materi Belum Tersedia
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
