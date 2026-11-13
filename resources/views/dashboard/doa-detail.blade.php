<x-be.layouts.app title="Detail Permohonan Doa" description="Detail permohonan doa">

    <main class="mx-auto w-full max-w-4xl flex-1 space-y-6">

        <x-be.page-header
            title="Detail Permohonan Doa"
            :description="$doa->nama_lengkap"
        >
            <x-slot:actions>
                <a href="{{ route('admin.doa.index') }}" class="be-btn be-btn-ghost">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    Kembali
                </a>
            </x-slot:actions>
        </x-be.page-header>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-success/30 bg-success/10 p-4 text-sm font-medium text-success" role="status">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Kartu utama --}}
            <x-be.card class="overflow-hidden lg:col-span-2">
                <div class="p-6 lg:p-7">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="be-badge bg-accent/10 text-accent dark:text-accent-soft">{{ $doa->kategori_label }}</span>
                        <span class="be-badge
                            {{ $doa->status === 'selesai'
                                ? 'bg-success/15 text-success'
                                : ($doa->status === 'diproses'
                                    ? 'bg-warning/15 text-warning'
                                    : 'bg-surface text-muted') }}">
                            {{ $doa->status_label }}
                        </span>
                    </div>

                    <h2 class="mt-4 text-xl font-bold text-ink">Isi Permohonan Doa</h2>

                    <div class="mt-3 rounded-2xl border border-line bg-ink/[0.02] p-5 text-sm leading-relaxed text-ink">
                        {{ $doa->isi_doa }}
                    </div>

                    <div class="mt-6 grid gap-4 border-t border-line pt-5 text-sm sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-muted">Nama Lengkap</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Jenis Kelamin</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Nomor HP</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->nomor_hp }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Boleh dihubungi</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->boleh_dihubungi ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        @if ($doa->alamat)
                            <div class="sm:col-span-2">
                                <p class="text-xs text-muted">Alamat</p>
                                <p class="mt-0.5 font-medium text-ink">{{ $doa->alamat }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-muted">Dikirim</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->created_at->translatedFormat('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Selesai didoakan</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $doa->didoakan_pada?->translatedFormat('d F Y') ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </x-be.card>

            {{-- Aksi --}}
            <div class="space-y-6">
                {{-- Ubah status --}}
                <x-be.card>
                    <div class="p-5">
                        <h3 class="text-sm font-bold text-ink">Ubah Status</h3>
                        <form method="POST" action="{{ route('admin.doa.status', $doa) }}" class="mt-4 space-y-4">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                                @foreach ($status as $key => $label)
                                    <option value="{{ $key }}" @selected($doa->status === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong">
                                Simpan Status
                            </button>
                        </form>
                    </div>
                </x-be.card>

                {{-- Hapus (soft delete) --}}
                <x-be.card x-data="{ open: false }">
                    <div class="p-5">
                        <h3 class="text-sm font-bold text-danger">Hapus</h3>
                        <p class="mt-1 text-xs leading-relaxed text-muted">
                            Memindahkan ke keranjang sampah.
                        </p>
                        <button type="button" x-on:click="open = true" class="mt-3 w-full rounded-full border border-danger/30 px-5 py-2.5 text-sm font-medium text-danger transition-colors hover:bg-danger/10">
                            Hapus Permohonan
                        </button>
                    </div>

                    {{-- Modal konfirmasi --}}
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        x-on:keydown.escape.window="open = false"
                        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                        style="display: none;"
                    >
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                            class="w-full max-w-md rounded-3xl bg-card p-6 shadow-2xl"
                            x-on:click.outside="open = false"
                            role="dialog"
                            aria-modal="true"
                        >
                            <div class="flex items-start gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                                <div class="space-y-1.5">
                                    <h3 class="text-base font-bold text-ink">Hapus Permohonan?</h3>
                                    <p class="text-sm text-muted">
                                        Data dari <span class="font-medium text-ink">{{ $doa->nama_lengkap }}</span>
                                        dipindahkan ke keranjang sampah.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-2.5">
                                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                                <form method="POST" action="{{ route('admin.doa.destroy', $doa) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-be.button type="submit" variant="danger" icon="fa-trash-can">Hapus</x-be.button>
                                </form>
                            </div>
                        </div>
                    </div>
                </x-be.card>
            </div>
        </div>

        {{-- Catatan internal (hanya admin) --}}
        <x-be.card>
            <div class="p-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-bold text-ink">Catatan Internal</h3>
                        <p class="mt-1 text-xs text-muted">Hanya terlihat oleh admin. Tidak pernah muncul di halaman publik.</p>
                    </div>
                    @if ($doa->catatan_internal)
                        <span class="text-xs text-muted">Diperbarui: {{ $doa->updated_at->translatedFormat('d F Y H:i') }}</span>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.doa.catatan', $doa) }}" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <textarea
                        name="catatan_internal"
                        rows="3"
                        maxlength="2000"
                        placeholder="Tulis catatan tindak lanjut di sini..."
                        class="w-full rounded-xl border border-line bg-surface px-4 py-2.5 text-sm text-ink placeholder:text-muted focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30"
                    >{{ old('catatan_internal', $doa->catatan_internal) }}</textarea>
                    @error('catatan_internal') <p class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p> @enderror
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-accent-strong">
                            Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </x-be.card>

    </main>

</x-be.layouts.app>
