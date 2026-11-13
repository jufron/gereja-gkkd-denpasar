@php
    $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
    $inputBase = 'mt-2 w-full min-h-11 rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted ' . $focusRing;
    $inputError = 'mt-2 w-full min-h-11 rounded-xl border border-danger bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted ' . $focusRing;
@endphp

<x-fe.layout.app
    title="Evaluasi Khotbah Bulanan — GKKD Denpasar"
    description="Beri masukan untuk khotbah bulan ini. Suara Anda membentuk mimbar GKKD Denpasar."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-14 lg:pt-16 lg:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Evaluasi Bulanan
                </span>
                <h1 class="mt-4 font-display text-4xl leading-[1.15] font-normal tracking-tight text-ink sm:text-5xl">
                    Evaluasi Khotbah Bulanan
                </h1>
                <p class="mt-4 max-w-[54ch] text-base leading-relaxed text-muted">
                    Setiap bulan kami ingin mendengar bagaimana firman yang disampaikan menolong Anda.
                    Evaluasi ini dibuka satu kali tiap bulan dan hanya membutuhkan ±3 menit.
                </p>
                <ul class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-medium text-muted">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Satu kali per bulan
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        ±3 menit
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Anonim & privat
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-start gap-10 lg:grid-cols-12 lg:gap-12">

                {{-- Aside info --}}
                <aside class="lg:col-span-5 lg:sticky lg:top-24" data-reveal>
                    <div class="relative">
                        <div aria-hidden="true" class="pointer-events-none absolute -top-8 -right-4 -z-10 opacity-50">
                            <x-fe.prayer-illustration class="h-48 w-48 text-accent/25" />
                        </div>

                        <h2 class="text-2xl font-bold tracking-tight text-ink">Mengapa kami bertanya?</h2>

                        <p class="mt-4 text-sm leading-relaxed text-muted">
                            Khotbah adalah makanan rohani jemaat. Masukan Anda membantu tim mimbar menyesuaikan
                            isi, cara penyampaian, dan topik-topik yang relevan dengan pergumulan kita bersama.
                        </p>

                        <ul class="mt-6 space-y-5 text-sm text-muted">
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Relevansi</h3>
                                    <p class="mt-1 leading-relaxed">Apakah pesan menyentuh hidup nyata jemaat?</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Penyampaian</h3>
                                    <p class="mt-1 leading-relaxed">Apakah khotbah mudah diikuti dan menggugah?</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12h18"/><path d="M12 3v18"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Topik mendatang</h3>
                                    <p class="mt-1 leading-relaxed">Topik apa yang ingin Anda dengar bulan depan?</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </aside>

                {{-- Form --}}
                <div class="lg:col-span-7" data-reveal style="transition-delay:80ms">
                    @if (session('success'))
                        <div
                            class="rounded-3xl border border-success/30 bg-success/10 p-8 text-center sm:p-10"
                            role="status"
                            tabindex="-1"
                            x-data
                            x-init="$el.focus()"
                        >
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-success/15 text-success">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            </div>
                            <h2 class="mt-5 font-display text-3xl font-normal text-ink">Terima kasih atas evaluasi Anda</h2>
                            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                                Masukan Anda membantu kami membentuk mimbar yang lebih membangun. Sampai jumpa di evaluasi bulan depan.
                            </p>
                            <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                                <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    @else
                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border border-danger/30 bg-danger/10 p-5" role="alert">
                                <h2 class="flex items-center gap-2 text-sm font-bold text-danger">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                                    Mohon periksa kembali formulir Anda
                                </h2>
                                <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('evaluasi-khotbah.kirim') }}"
                            class="rounded-3xl border border-line bg-surface p-6 shadow-sm sm:p-8"
                            x-data="{ submitting: false }"
                            x-on:submit="submitting = true"
                        >
                            @csrf

                            <div class="hidden" aria-hidden="true">
                                <label for="website">Jangan diisi</label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            {{-- Bulan & tahun --}}
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="bulan" class="block text-sm font-medium text-ink">Bulan yang dievaluasi <span class="text-danger">*</span></label>
                                    <select
                                        id="bulan"
                                        name="bulan"
                                        required
                                        aria-required="true"
                                        @error('bulan') aria-invalid="true" aria-describedby="bulan-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                    >
                                        @foreach ($bulan as $nomor => $nama)
                                            <option value="{{ $nomor }}" @selected((int) old('bulan', $bulanIni) === $nomor)>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan') <p id="bulan-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="tahun" class="block text-sm font-medium text-ink">Tahun <span class="text-danger">*</span></label>
                                    <select
                                        id="tahun"
                                        name="tahun"
                                        required
                                        aria-required="true"
                                        @error('tahun') aria-invalid="true" aria-describedby="tahun-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                    >
                                        @foreach ($tahunOptions as $tahun)
                                            <option value="{{ $tahun }}" @selected((int) old('tahun', $tahunIni) === $tahun)>{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun') <p id="tahun-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Rating --}}
                            <div class="mt-6">
                                <fieldset>
                                    <legend class="text-sm font-medium text-ink">Penilaian keseluruhan bulan ini <span class="text-danger">*</span></legend>
                                    <div class="mt-2 grid grid-cols-5 gap-2">
                                        @foreach ($rating as $nilai => $label)
                                            <label
                                                class="cursor-pointer"
                                                x-data
                                                x-on:keydown.arrow-right.prevent="$refs.r{{ $nilai + 1 }}?.focus()"
                                                x-on:keydown.arrow-left.prevent="$refs.r{{ $nilai - 1 }}?.focus()"
                                            >
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="{{ $nilai }}"
                                                    id="rating_{{ $nilai }}"
                                                    x-ref="r{{ $nilai }}"
                                                    class="peer sr-only"
                                                    required
                                                    @checked((string) old('rating') === (string) $nilai)
                                                    @error('rating') aria-invalid="true" aria-describedby="rating-error" @enderror
                                                >
                                                <span
                                                    class="flex h-12 flex-col items-center justify-center rounded-xl border border-line bg-surface text-sm font-semibold text-ink transition-colors peer-checked:border-accent peer-checked:bg-accent peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-accent hover:border-accent/50"
                                                    title="{{ $label }}"
                                                >
                                                    {{ $nilai }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-xs text-muted">1 = sangat kurang · 5 = sangat baik</p>
                                    @error('rating') <p id="rating-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                </fieldset>
                            </div>

                            {{-- Nama opsional --}}
                            <div class="mt-6">
                                <label for="nama" class="block text-sm font-medium text-ink">Nama (opsional)</label>
                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    value="{{ old('nama') }}"
                                    maxlength="100"
                                    placeholder="Boleh diisi, boleh kosong"
                                    @error('nama') aria-invalid="true" aria-describedby="nama-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                >
                                @error('nama') <p id="nama-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                            </div>

                            {{-- Teks umpan balik --}}
                            <div class="mt-6 space-y-5">
                                <div>
                                    <label for="berkesan" class="block text-sm font-medium text-ink">Apa yang paling berkesan bulan ini?</label>
                                    <textarea
                                        id="berkesan"
                                        name="berkesan"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Ceritakan khotbah yang paling menolong Anda..."
                                        @error('berkesan') aria-invalid="true" aria-describedby="berkesan-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                    >{{ old('berkesan') }}</textarea>
                                    @error('berkesan') <p id="berkesan-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="masukan" class="block text-sm font-medium text-ink">Masukan / saran konstruktif</label>
                                    <textarea
                                        id="masukan"
                                        name="masukan"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Apa yang bisa kami perbaiki?"
                                        @error('masukan') aria-invalid="true" aria-describedby="masukan-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                    >{{ old('masukan') }}</textarea>
                                    @error('masukan') <p id="masukan-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="mt-6 border-t border-line pt-6">
                                <label class="flex items-start gap-3 text-sm text-muted">
                                    <input
                                        type="checkbox"
                                        name="persetujuan"
                                        value="1"
                                        required
                                        aria-required="true"
                                        @error('persetujuan') aria-invalid="true" aria-describedby="persetujuan-error" @enderror
                                        class="mt-0.5 h-5 w-5 rounded border-line text-accent {{ $focusRing }}"
                                    >
                                    <span>
                                        Saya menyetujui data ini diproses untuk evaluasi pelayanan, sesuai
                                        <a href="{{ route('kebijakan-privasi') }}" class="font-medium text-accent hover:underline dark:text-accent-soft">Kebijakan Privasi</a>.
                                        <span class="text-danger">*</span>
                                    </span>
                                </label>
                                @error('persetujuan') <p id="persetujuan-error" class="text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                            </div>

                            {{-- Action bar --}}
                            <div class="mt-7 flex flex-col-reverse items-stretch gap-3 border-t border-line pt-6 sm:flex-row sm:items-center sm:justify-between">
                                <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-full border border-line bg-surface px-5 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft {{ $focusRing }}">
                                    &larr; Kembali
                                </a>
                                <button
                                    type="submit"
                                    :disabled="submitting"
                                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-accent px-8 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong disabled:cursor-not-allowed disabled:opacity-60 {{ $focusRing }}"
                                >
                                    <span x-show="!submitting">Kirim Evaluasi</span>
                                    <span x-show="submitting" x-cloak>Mengirim…</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </section>
</x-fe.layout.app>
