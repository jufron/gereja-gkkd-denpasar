@php
    $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
    $inputBase = 'mt-2 w-full min-h-11 rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted ' . $focusRing;
    $inputError = 'mt-2 w-full min-h-11 rounded-xl border border-danger bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted ' . $focusRing;
@endphp

<x-fe.layout.app
    title="Permohonan Doa — GKKD Denpasar"
    description="Ceritakan pergumulan Anda dan tim doa GKKD Denpasar akan mendoakan secara pribadi, tanpa dipublikasikan."
>
    {{-- Header --}}
    <section class="border-b border-line bg-ink/5 pt-12 pb-14 lg:pt-16 lg:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3 py-1 text-xs font-medium text-muted">
                    Pelayanan Doa
                </span>
                <h1 class="mt-4 font-display text-4xl leading-[1.15] font-normal tracking-tight text-ink sm:text-5xl">
                    Ceritakan Pergumulan Anda
                </h1>
                <p class="mt-4 max-w-[54ch] text-base leading-relaxed text-muted">
                    Isi formulir ini dan tim doa GKKD Denpasar akan mendoakan Anda.
                    Tidak ada pergumulan yang terlalu kecil untuk dibawa dalam doa.
                </p>
                <ul class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-medium text-muted">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Privat
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Didoakan tim doa
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Tanpa akun
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

                        <h2 class="text-2xl font-bold tracking-tight text-ink">Yang perlu Anda tahu</h2>

                        <ul class="mt-6 space-y-5 text-sm text-muted">
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Sepenuhnya privat</h3>
                                    <p class="mt-1 leading-relaxed">Permohonan tidak pernah muncul di halaman publik. Hanya Administrator dashboard yang dapat mengaksesnya.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-4.6-9.5-9A5.5 5.5 0 0 1 12 6.5 5.5 5.5 0 0 1 21.5 12c-2.5 4.4-9.5 9-9.5 9Z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Didoakan tim pelayanan</h3>
                                    <p class="mt-1 leading-relaxed">Setiap permohonan dibaca dan dibawa dalam doa oleh tim doa gereja.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent dark:text-accent-soft">
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-ink">Bisa dihubungi</h3>
                                    <p class="mt-1 leading-relaxed">Kami hanya menghubungi bila Anda memberi izin — misalnya untuk tindak lanjut pastoral.</p>
                                </div>
                            </li>
                        </ul>

                        <blockquote class="mt-8 rounded-2xl border border-accent/20 bg-accent/5 p-5 text-sm italic leading-relaxed text-muted">
                            "Serahkanlah kuatirmu kepada Tuhan, maka Ia akan memelihara engkau." — Mazmur 55:23
                        </blockquote>

                        <p class="mt-6 text-xs text-muted">
                            Bagikan hal lain lewat
                            <a href="{{ route('kontak') }}" class="font-medium text-accent hover:underline dark:text-accent-soft">halaman Kontak</a>.
                        </p>
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
                            <h2 class="mt-5 font-display text-3xl font-normal text-ink">Permohonan Anda sudah kami terima</h2>
                            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                                Tim doa akan mendoakan pergumulan Anda. Jika Anda mengizinkan, kami akan menghubungi lewat nomor yang terdaftar.
                            </p>
                            <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                                <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-accent-strong {{ $focusRing }}">
                                    Kembali ke Beranda
                                </a>
                                <a href="{{ route('doa') }}" class="inline-flex min-h-11 items-center justify-center rounded-full border border-line bg-surface px-6 py-3 text-sm font-medium text-ink transition-colors hover:border-accent hover:text-accent dark:hover:text-accent-soft {{ $focusRing }}">
                                    Kirim Permohonan Lain
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Error summary --}}
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
                            action="{{ route('doa.kirim') }}"
                            class="rounded-3xl border border-line bg-surface p-6 shadow-sm sm:p-8"
                            x-data="{ submitting: false }"
                            x-on:submit="submitting = true"
                        >
                            @csrf

                            {{-- Honeypot --}}
                            <div class="hidden" aria-hidden="true">
                                <label for="website">Jangan diisi</label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            {{-- Grup: Tentang Anda --}}
                            <div class="border-b border-line pb-6">
                                <h2 class="text-base font-bold text-ink">Tentang Anda</h2>
                                <p class="mt-1 text-xs text-muted">Dipakai tim doa untuk mengidentifikasi dan menghubungi Anda.</p>

                                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <label for="nama_lengkap" class="block text-sm font-medium text-ink">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            id="nama_lengkap"
                                            name="nama_lengkap"
                                            value="{{ old('nama_lengkap') }}"
                                            required
                                            aria-required="true"
                                            maxlength="100"
                                            @error('nama_lengkap') aria-invalid="true" aria-describedby="nama_lengkap-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                            placeholder="Nama Anda"
                                        >
                                        @error('nama_lengkap') <p id="nama_lengkap-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-ink">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select
                                            id="jenis_kelamin"
                                            name="jenis_kelamin"
                                            required
                                            aria-required="true"
                                            @error('jenis_kelamin') aria-invalid="true" aria-describedby="jenis_kelamin-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                        >
                                            <option value="">— Pilih —</option>
                                            <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                            <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin') <p id="jenis_kelamin-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="nomor_hp" class="block text-sm font-medium text-ink">Nomor HP <span class="text-danger">*</span></label>
                                        <input
                                            type="tel"
                                            id="nomor_hp"
                                            name="nomor_hp"
                                            value="{{ old('nomor_hp') }}"
                                            required
                                            aria-required="true"
                                            maxlength="20"
                                            placeholder="08xxxxxxxxxx"
                                            @error('nomor_hp') aria-invalid="true" aria-describedby="nomor_hp-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                        >
                                        @error('nomor_hp') <p id="nomor_hp-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                        <p class="mt-1.5 text-xs text-muted">Kami hanya menghubungi bila Anda mengizinkan.</p>
                                    </div>

                                    <div>
                                        <label for="alamat" class="block text-sm font-medium text-ink">Alamat</label>
                                        <textarea
                                            id="alamat"
                                            name="alamat"
                                            rows="2"
                                            maxlength="500"
                                            @error('alamat') aria-invalid="true" aria-describedby="alamat-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                            placeholder="Alamat lengkap (opsional)"
                                        >{{ old('alamat') }}</textarea>
                                        @error('alamat') <p id="alamat-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Grup: Permohonan Doa --}}
                            <div class="mt-6">
                                <h2 class="text-base font-bold text-ink">Permohonan Doa</h2>
                                <p class="mt-1 text-xs text-muted">Ceritakan pergumulan Anda sedetail yang Anda nyaman.</p>

                                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <label for="kategori" class="block text-sm font-medium text-ink">Kategori <span class="text-danger">*</span></label>
                                        <select
                                            id="kategori"
                                            name="kategori"
                                            required
                                            aria-required="true"
                                            @error('kategori') aria-invalid="true" aria-describedby="kategori-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                        >
                                            @foreach ($kategori as $key => $label)
                                                <option value="{{ $key }}" @selected(old('kategori') === $key)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori') <p id="kategori-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <label for="isi_doa" class="block text-sm font-medium text-ink">Permohonan Doa <span class="text-danger">*</span></label>
                                    <textarea
                                        id="isi_doa"
                                        name="isi_doa"
                                        rows="6"
                                        required
                                        aria-required="true"
                                        minlength="10"
                                        maxlength="2000"
                                        placeholder="Tuliskan pergumulan atau permohonan doa Anda..."
                                        x-data="{ len: {{ strlen(old('isi_doa', '')) }} }"
                                        x-on:input="len = $el.value.length"
                                        @error('isi_doa') aria-invalid="true" aria-describedby="isi_doa-error" class="{{ $inputError }}" @else class="{{ $inputBase }}" @enderror
                                    >{{ old('isi_doa') }}</textarea>
                                    @error('isi_doa') <p id="isi_doa-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                                    <div class="mt-1.5 flex items-center justify-between text-xs">
                                        <span class="text-muted">Maksimal 2.000 karakter.</span>
                                        <span class="font-medium" :class="len > 1800 ? 'text-warning' : 'text-muted'" x-text="len + ' / 2000'">0 / 2000</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Persetujuan --}}
                            <div class="mt-6 space-y-4 border-t border-line pt-6">
                                <label class="flex items-start gap-3 text-sm text-muted">
                                    <input
                                        type="checkbox"
                                        name="boleh_dihubungi"
                                        value="1"
                                        @checked(old('boleh_dihubungi', true))
                                        class="mt-0.5 h-5 w-5 rounded border-line text-accent {{ $focusRing }}"
                                    >
                                    <span>Saya bersedia dihubungi tim doa untuk tindak lanjut.</span>
                                </label>

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
                                        Saya memahami data ini disimpan untuk pelayanan doa sesuai
                                        <a href="{{ route('kebijakan-privasi') }}" class="font-medium text-accent hover:underline dark:text-accent-soft">Kebijakan Privasi</a>
                                        dan tidak dipublikasikan. <span class="text-danger">*</span>
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
                                    <span x-show="!submitting">Kirim Permohonan Doa</span>
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
