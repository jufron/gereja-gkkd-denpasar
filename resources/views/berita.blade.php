<x-fe.layout.app
    title="Berita & Warta — GKKD Denpasar"
    description="Kabar terkini seputar kegiatan jemaat, pengumuman pelayanan, dan artikel renungan firman di GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Warta & Kabar Jemaat
                </span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Berita, Pengumuman, dan Renungan
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    Ikuti perkembangan pelayanan gereja, agenda khusus jemaat, dan renungan firman peneguh iman setiap pekan.
                </p>
            </div>
        </div>
    </section>

    {{-- Artikel Utama / Berita Sorotan --}}
    @if ($featured)
        <section class="py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="group relative overflow-hidden rounded-3xl border border-line bg-surface shadow-sm transition-all hover:border-accent/40">
                    <div class="grid items-center lg:grid-cols-12">
                        <div class="p-8 sm:p-12 lg:col-span-7">
                            <div class="flex items-center gap-3">
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                    Sorotan Minggu Ini
                                </span>
                                <span class="text-xs text-muted">{{ $featured->date }}</span>
                            </div>
                            <h2 class="mt-4 text-2xl font-bold tracking-tight text-ink sm:text-3xl">
                                {{ $featured->title }}
                            </h2>
                            <p class="mt-4 text-base leading-relaxed text-muted">
                                {{ $featured->excerpt }}
                            </p>
                            <div class="mt-6 flex items-center gap-4">
                                <span class="text-xs font-medium text-muted">Oleh Tim Pastoral GKKD</span>
                                <span class="text-xs text-muted">•</span>
                                <span class="text-xs font-medium text-accent dark:text-accent-soft">{{ $featured->status }}</span>
                            </div>
                        </div>

                        <div class="aspect-16/10 overflow-hidden bg-ink/5 lg:col-span-5 lg:aspect-auto lg:h-full">
                            <img
                                src="{{ $featured->image }}"
                                alt="{{ $featured->title }}"
                                width="600"
                                height="450"
                                loading="eager"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Grid Berita & Pengumuman --}}
    <section id="warta" class="border-t border-line bg-ink/5 py-16 lg:py-24 scroll-mt-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h2 class="text-3xl font-semibold tracking-tight text-ink">
                        Warta & Informasi Pelayanan
                    </h2>
                    <p class="mt-2 text-sm text-muted">Kabar kegiatan terbaru dan rencana pelayanan mendatang.</p>
                </div>
            </div>

            {{-- Search & Filter Kategori --}}
            <div class="mt-8 flex flex-col gap-5">
                <form
                    method="GET"
                    action="{{ route('berita') }}"
                    class="flex items-center gap-3"
                    role="search"
                >
                    <label for="berita-search" class="sr-only">Cari berita</label>
                    <input
                        type="search"
                        id="berita-search"
                        name="q"
                        value="{{ $q }}"
                        placeholder="Cari judul atau isi berita…"
                        class="w-full max-w-md rounded-full border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent"
                    >
                    @if ($kategori)
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                    @endif
                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                    >
                        Cari
                    </button>
                </form>

                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('berita', array_filter(['q' => $q])) }}"
                        class="rounded-full px-3.5 py-1.5 text-xs font-medium transition-colors {{ is_null($kategori) ? 'bg-accent/10 font-semibold text-accent dark:bg-accent/20 dark:text-accent-soft' : 'border border-line bg-surface text-muted hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft' }}"
                    >
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a
                            href="{{ route('berita', array_filter(['q' => $q, 'kategori' => $cat])) }}"
                            class="rounded-full px-3.5 py-1.5 text-xs font-medium transition-colors {{ ($kategori === $cat) ? 'bg-accent/10 font-semibold text-accent dark:bg-accent/20 dark:text-accent-soft' : 'border border-line bg-surface text-muted hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft' }}"
                        >
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                <p class="text-xs text-muted">
                    {{ $paginator->total() }} artikel{{ $q !== '' ? ' untuk pencarian "' . $q . '"' : '' }}{{ $kategori ? ' kategori ' . $kategori : '' }}
                </p>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($paginator as $article)
                    @if ($featured && $loop->first)
                        @continue
                    @endif
                    <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                        <div>
                            <div class="aspect-16/10 overflow-hidden bg-ink/5">
                                <img
                                    src="{{ $article->image }}"
                                    alt="{{ $article->title }}"
                                    width="500"
                                    height="300"
                                    loading="lazy"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2">
                                    <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">{{ $article->category }}</span>
                                    <span class="text-xs text-muted">{{ $article->date }}</span>
                                </div>
                                <h3 class="mt-3 text-lg font-semibold text-ink">
                                    {{ $article->title }}
                                </h3>
                                <p class="mt-2 text-sm leading-relaxed text-muted">
                                    {{ $article->excerpt }}
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-line px-6 py-4">
                            @if ($article->link_url)
                                <a href="{{ $article->link_url }}" class="text-xs font-semibold text-accent hover:underline dark:text-accent-soft">
                                    {{ $article->link_label }} &rarr;
                                </a>
                            @elseif ($article->status)
                                <span class="text-xs font-semibold text-accent dark:text-accent-soft">{{ $article->status }}</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 lg:col-span-3">
                        <div class="rounded-2xl border border-dashed border-line bg-surface p-10 text-center">
                            <p class="text-base font-medium text-ink">Tidak ada berita yang ditemukan.</p>
                            <p class="mt-2 text-sm text-muted">Coba kata kunci lain atau pilih kategori berbeda.</p>
                            <a
                                href="{{ route('berita') }}"
                                class="mt-6 inline-flex items-center justify-center rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong"
                            >
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($paginator->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $paginator->links() }}
                </div>
            @endif
        </div>
    </section>
</x-fe.layout.app>
