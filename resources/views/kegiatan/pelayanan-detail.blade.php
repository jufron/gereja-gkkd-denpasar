<x-fe.layout.app
    :title="$tim['name'].' — GKKD Denpasar'"
    :description="Str::limit($tim['intro'], 155)"
>
    {{-- Header --}}
    <section class="relative overflow-hidden border-b border-line bg-ink/5 pt-12 pb-16 lg:pt-16 lg:pb-20">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -right-24 h-80 w-80 rounded-full bg-accent/10 blur-3xl hero-float"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-reveal>
                <a href="{{ route('kegiatan.pelayanan') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted transition-colors hover:text-accent dark:hover:text-accent-soft">
                    &larr; Kembali ke Pelayanan
                </a>
                <span class="mt-6 inline-flex rounded-full border border-line bg-surface px-3 py-1 text-xs font-semibold text-accent dark:text-accent-soft">{{ $tim['badge'] }}</span>
                <h1 class="mt-4 text-4xl leading-[1.12] font-semibold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    {{ $tim['name'] }}
                </h1>
                <p class="mt-4 text-base leading-relaxed text-muted sm:text-lg">
                    {{ $tim['headline'] }}
                </p>
            </div>
        </div>
    </section>

    {{-- Intro + gambar --}}
    <section class="py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-6" data-reveal>
                    <div class="aspect-[4/3] overflow-hidden rounded-3xl bg-ink/5">
                        <img src="{{ $tim['image'] }}" alt="{{ $tim['alt'] }}" class="h-full w-full object-cover" loading="lazy" width="1200" height="900">
                    </div>
                </div>
                <div class="lg:col-span-6" data-reveal style="transition-delay:100ms">
                    <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Apa yang perlu dipelajari</h2>
                    <p class="mt-4 text-base leading-relaxed text-muted">
                        {{ $tim['intro'] }}
                    </p>
                    <ul class="mt-6 space-y-3 text-sm leading-relaxed text-muted">
                        @foreach ($tim['learn'] as $item)
                            <li class="flex gap-3"><span aria-hidden="true" class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-accent"></span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Ketua & Anggota --}}
    <section class="bg-ink/5 py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl" data-reveal>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Ketua &amp; Anggota</h2>
                <p class="mt-3 text-base leading-relaxed text-muted">Jemaat yang menopang dan menggerakkan {{ $tim['name'] }}.</p>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-accent/30 bg-surface p-6" data-reveal>
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 font-bold text-accent dark:text-accent-soft">K</span>
                    <h3 class="mt-4 text-base font-semibold text-ink">{{ $tim['lead'] }}</h3>
                    <p class="mt-1 text-sm text-muted">Ketua Tim</p>
                </div>
                @foreach ($tim['members'] as $member)
                    <div class="rounded-2xl border border-line bg-surface p-6" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 font-bold text-accent dark:text-accent-soft">A</span>
                        <h3 class="mt-4 text-base font-semibold text-ink">{{ $member }}</h3>
                        <p class="mt-1 text-sm text-muted">Anggota</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tugas & Tanggung Jawab --}}
    <section class="py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5" data-reveal>
                    <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Tugas &amp; Tanggung Jawab</h2>
                    <p class="mt-4 text-base leading-relaxed text-muted">Bagian apa yang diemban tiap anggota agar pelayanan berjalan tertib.</p>
                </div>
                <div class="lg:col-span-7" data-reveal style="transition-delay:100ms">
                    <ul class="space-y-4">
                        @foreach ($tim['duties'] as $item)
                            <li class="flex gap-4 rounded-2xl border border-line bg-surface p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-accent/40">
                                <span aria-hidden="true" class="mt-2 h-2 w-2 shrink-0 rounded-full bg-accent"></span>
                                <span class="text-sm leading-relaxed text-muted">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Jadwal --}}
    <section class="bg-ink/5 py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:order-2 lg:col-span-5" data-reveal>
                    <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Jadwal Latihan</h2>
                    <p class="mt-4 text-base leading-relaxed text-muted">Waktu berkumpul dan berlatih bersama agar pelayanan semakin matang.</p>
                </div>
                <div class="lg:order-1 lg:col-span-7" data-reveal style="transition-delay:100ms">
                    <ul class="space-y-4">
                        @foreach ($tim['schedule'] as $item)
                            <li class="flex gap-4 rounded-2xl border border-line bg-surface p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-accent/40">
                                <span aria-hidden="true" class="mt-2 h-2 w-2 shrink-0 rounded-full bg-accent"></span>
                                <span class="text-sm leading-relaxed text-muted">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Persyaratan --}}
    <section class="py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl" data-reveal>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Siap bergabung?</h2>
                <p class="mt-3 text-base leading-relaxed text-muted">Yang perlu Anda miliki untuk melayani di {{ $tim['name'] }}:</p>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($tim['requirements'] as $item)
                    <div class="rounded-2xl border border-line bg-surface p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-accent/40" data-reveal style="transition-delay:{{ $loop->iteration * 80 }}ms">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-accent/10 font-bold text-accent dark:text-accent-soft">✓</span>
                        <p class="mt-4 text-sm leading-relaxed text-muted">{{ $item }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden border-t border-line py-16 lg:py-24">
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-accent/10 blur-3xl hero-float-slow"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center" data-reveal>
                <h2 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Tertarik melayani di tim ini?</h2>
                <p class="mt-4 text-base leading-relaxed text-muted">Ceritakan minat Anda, kami akan menghubungkan Anda dengan {{ $tim['name'] }}.</p>
                <a
                    href="https://wa.me/6281234567890?text={{ rawurlencode($tim['wa']) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-8 inline-flex items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent-strong hover:shadow-[0_12px_28px_-10px_rgba(138,0,194,0.6)]"
                >
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-fe.layout.app>
