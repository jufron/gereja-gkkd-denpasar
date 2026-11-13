<x-fe.layout.app
    title="{{ $news->title }} — GKKD Denpasar"
    description="{{ $news->excerpt ?? strip_tags($news->content) }}"
>
    <?php $readTime = max(1, (int) ceil(str_word_count(strip_tags($news->content)) / 200)); ?>

    {{-- Reading progress bar (CSS-native, tanpa JS) --}}
    <div aria-hidden="true" class="reading-progress fixed inset-x-0 top-0 z-50 h-1 bg-transparent"></div>

    {{-- Header / Breadcrumb --}}
    <section class="border-b border-line bg-ink/5 pt-10 pb-12 lg:pt-14 lg:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <a href="{{ route('berita') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Warta & Berita
                </a>

                <div class="mt-5 flex flex-wrap items-center gap-2.5">
                    @if ($news->category)
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $news->category->color }}">
                            {{ $news->category->name }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 text-xs text-muted">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        {{ $news->published_at?->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-muted">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        {{ $readTime }} Menit Baca
                    </span>
                </div>

                <h1 class="mt-4 text-3xl leading-tight font-semibold tracking-tight text-ink sm:text-4xl lg:text-5xl">
                    {{ $news->title }}
                </h1>

                <div class="mt-6 flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-tr from-accent-strong to-accent text-base font-bold text-white ring-2 ring-line">
                        {{ \Illuminate\Support\Str::substr($news->author?->name ?? 'GKKD', 0, 1) }}
                    </span>
                    <div>
                        <p class="text-base font-semibold text-ink">{{ $news->author?->name ?? 'Tim Pastoral GKKD' }}</p>
                        <p class="text-xs text-muted">Penulis Artikel</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Konten --}}
    <section class="py-12 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">

                {{-- Kiri: artikel --}}
                <div class="lg:col-span-8">
                    @if ($news->banner_url)
                        <div class="overflow-hidden rounded-3xl border border-line bg-ink/5">
                            <img
                                src="{{ $news->banner_url }}"
                                alt="{{ $news->title }}"
                                width="1200"
                                height="675"
                                class="h-auto w-full object-cover"
                            >
                        </div>
                    @endif

                    <article class="mt-8">
                        <div class="berita-content">
                            {!! $news->content !!}
                        </div>
                    </article>

                    <div class="mt-10 flex items-center justify-between border-t border-line pt-6">
                        <a
                            href="{{ route('berita') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-accent dark:text-accent-soft hover:underline underline-offset-4"
                        >
                            &larr; Semua Berita
                        </a>
                    </div>
                </div>

                {{-- Kanan: sidebar sticky --}}
                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">

                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <h2 class="text-base font-semibold text-ink">Bagikan Artikel</h2>
                            <div class="mt-4" x-data="{
                                copied: false,
                                copy() {
                                    navigator.clipboard.writeText(window.location.href).then(() => {
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 2500);
                                    });
                                }
                            }">
                                <button
                                    type="button"
                                    @click="copy()"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-line bg-surface px-5 py-2.5 text-sm font-medium text-ink transition-all hover:border-accent hover:text-accent dark:hover:text-accent-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                                >
                                    <svg x-show="!copied" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                    <svg x-show="copied" x-cloak class="h-4 w-4 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                                </button>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-line bg-surface p-6">
                            <h2 class="text-base font-semibold text-ink">Kategori</h2>
                            <ul class="mt-4 flex flex-wrap gap-2">
                                @foreach ($categories ?? [] as $cat)
                                    <li>
                                        <a
                                            href="{{ route('berita', ['kategori' => $cat->slug]) }}"
                                            class="inline-flex rounded-full border border-line bg-surface px-3.5 py-1.5 text-xs font-medium text-muted transition-colors hover:border-accent/50 hover:text-accent dark:hover:text-accent-soft"
                                        >
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl border border-line bg-[#101010] p-6 text-white">
                            <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 h-40 w-40 rounded-full bg-accent/20 blur-3xl"></div>
                            <h3 class="text-base font-semibold">Perlu Didoakan?</h3>
                            <p class="mt-2 text-sm leading-relaxed text-neutral-300">
                                Tim doa GKKD siap mendoakan pergumulan Anda secara pribadi.
                            </p>
                            <a
                                href="{{ route('doa') }}"
                                class="mt-5 inline-flex min-h-11 w-full items-center justify-center rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-soft"
                            >
                                Kirim Permohonan Doa
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Berita Terkait --}}
    @if ($related->isNotEmpty())
        <section class="border-t border-line py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <h2 class="text-3xl font-semibold tracking-tight text-ink">Berita Lainnya</h2>
                        <p class="mt-2 text-sm text-muted">Lanjutkan membaca kabar pelayanan jemaat.</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <article class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-line bg-surface transition-all hover:border-accent/40 hover:shadow-md">
                            <a href="{{ route('berita.show', $item->slug) }}" class="flex h-full flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-accent">
                                <div class="aspect-16/10 overflow-hidden bg-ink/5">
                                    <img
                                        src="{{ $item->banner_url ?: asset('images/church-sanctuary.jpg') }}"
                                        alt="{{ $item->title }}"
                                        width="500"
                                        height="312"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 motion-reduce:transform-none"
                                    >
                                </div>
                                <div class="flex flex-1 flex-col justify-between p-6">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $item->category?->color }}">
                                                {{ $item->category?->name ?? 'Berita' }}
                                            </span>
                                            <span class="text-xs text-muted">{{ $item->published_at?->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <h3 class="mt-3 text-base font-semibold leading-snug text-ink group-hover:text-accent dark:group-hover:text-accent-soft">
                                            {{ $item->title }}
                                        </h3>
                                    </div>
                                    <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-accent dark:text-accent-soft">
                                        Baca
                                        <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-0.5 motion-reduce:group-hover:translate-x-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69l-4.22-4.22a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-fe.layout.app>
