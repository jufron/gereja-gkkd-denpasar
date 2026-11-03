<div class="space-y-6">

    {{-- Notifikasi sementara --}}
    @if ($pesan)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex items-center gap-3 rounded-2xl border p-4 text-sm font-medium
                {{ $pesanTone === 'error'
                    ? 'border-danger/30 bg-danger/10 text-danger'
                    : 'border-success/30 bg-success/10 text-success' }}"
        >
            <i class="fa-solid {{ $pesanTone === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' }}"></i>
            <span>{{ $pesan }}</span>
        </div>
    @endif

    {{-- Tabel Banner --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Banner Slider Beranda</h3>
                <p class="text-xs text-muted">Total {{ $this->banners->count() }} banner. Tampil di bagian hero halaman utama.</p>
            </div>
            <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">Tambah Banner</x-be.button>
        </div>

        @if ($this->banners->isEmpty())
            <x-be.empty-state
                icon="fa-images"
                title="Belum ada banner"
                description="Tambahkan banner pertama untuk mengisi slider hero halaman utama."
            />
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Gambar</th>
                            <th class="px-6 py-3.5">Badge</th>
                            <th class="px-6 py-3.5">Caption</th>
                            <th class="px-6 py-3.5">Urutan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->banners as $banner)
                            <tr class="transition-colors hover:bg-ink/[0.02]">
                                <td class="px-6 py-4">
                                    @if ($banner->media)
                                        <img
                                            src="{{ $banner->media->getUrl() }}"
                                            alt="{{ $banner->alt }}"
                                            class="h-14 w-24 rounded-xl border border-line object-cover"
                                        >
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-[11px] font-semibold text-accent dark:text-accent-soft">
                                        {{ $banner->badge }}
                                    </span>
                                </td>
                                <td class="max-w-64 px-6 py-4">
                                    <span class="block truncate" title="{{ $banner->caption }}">{{ $banner->caption }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <button
                                            type="button"
                                            wire:click="naik({{ $banner->id }})"
                                            @disabled($loop->first)
                                            class="flex h-7 w-7 items-center justify-center rounded-lg border border-line text-muted transition-colors hover:border-accent hover:text-accent disabled:pointer-events-none disabled:opacity-30"
                                            aria-label="Naikkan urutan"
                                        >
                                            <i class="fa-solid fa-arrow-up text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="turun({{ $banner->id }})"
                                            @disabled($loop->last)
                                            class="flex h-7 w-7 items-center justify-center rounded-lg border border-line text-muted transition-colors hover:border-accent hover:text-accent disabled:pointer-events-none disabled:opacity-30"
                                            aria-label="Turunkan urutan"
                                        >
                                            <i class="fa-solid fa-arrow-down text-[10px]"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        type="button"
                                        wire:click="toggleAktif({{ $banner->id }})"
                                        class="inline-flex items-center gap-1.5 rounded-full text-[11px] font-semibold transition-colors
                                            {{ $banner->is_active
                                                ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                                                : 'bg-slate-500/10 text-slate-500 dark:text-slate-400' }}"
                                    >
                                        <i class="fa-solid {{ $banner->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                        {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="bukaFormUbah({{ $banner->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Ubah banner"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $banner->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus banner"
                                        >
                                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-be.card>

    {{-- Modal form tambah/ubah banner --}}
    <div
        x-data="{ open: @entangle('formOpen') }"
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
            class="flex max-h-[90vh] w-full max-w-lg flex-col rounded-3xl bg-card shadow-2xl"
            x-on:click.outside="open = false"
        >
            <div class="flex items-center justify-between border-b border-line p-6">
                <div>
                    <h3 class="text-base font-bold text-ink">{{ $bannerId ? 'Ubah Banner' : 'Tambah Banner Baru' }}</h3>
                    <p class="text-xs text-muted">Slider gambar di bagian hero halaman utama.</p>
                </div>
                <button
                    type="button"
                    x-on:click="open = false"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink"
                    aria-label="Tutup"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form wire:submit="simpan" class="space-y-5 overflow-y-auto p-6">
                <x-be.field label="Gambar Banner" for="foto" :help="$errors->first('foto')">
                    <input
                        id="foto"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        wire:model="foto"
                        class="be-input file:mr-3 file:rounded-lg file:border-0 file:bg-accent/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-accent {{ $errors->has('foto') ? 'border-danger' : '' }}"
                    >
                    @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}" alt="Pratinjau banner" class="mt-3 h-24 w-full rounded-xl border border-line object-cover">
                    @endif
                </x-be.field>

                <x-be.field label="Badge" for="badge" :help="$errors->first('badge')">
                    <input
                        id="badge"
                        type="text"
                        wire:model="badge"
                        placeholder="Contoh: Sanctuary GKKD Denpasar"
                        class="be-input {{ $errors->has('badge') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Caption" for="caption" :help="$errors->first('caption')">
                    <input
                        id="caption"
                        type="text"
                        wire:model="caption"
                        placeholder="Teks pendek di bawah badge"
                        class="be-input {{ $errors->has('caption') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Teks Alt" for="alt" :help="$errors->first('alt')">
                    <input
                        id="alt"
                        type="text"
                        wire:model="alt"
                        placeholder="Deskripsi gambar untuk aksesibilitas"
                        class="be-input {{ $errors->has('alt') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Tautan (opsional)" for="linkUrl" :help="$errors->first('link_url')">
                    <input
                        id="linkUrl"
                        type="url"
                        wire:model="linkUrl"
                        placeholder="https://..."
                        class="be-input {{ $errors->has('link_url') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-line p-3.5">
                    <input type="checkbox" wire:model="isActive" class="h-4 w-4 rounded border-line text-accent focus:ring-accent">
                    <span class="text-sm font-medium text-ink">Tampilkan di beranda</span>
                </label>

                <div class="flex items-center justify-end gap-2.5 border-t border-line pt-5">
                    <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check">{{ $bannerId ? 'Simpan' : 'Tambah Banner' }}</x-be.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div
        x-data="{ open: @entangle('hapusOpen') }"
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
        >
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-ink">Hapus Banner?</h3>
                    <p class="text-sm text-muted">
                        Banner akan dihapus permanen. File gambarnya ikut dibersihkan oleh media:prune.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">Hapus Banner</x-be.button>
            </div>
        </div>
    </div>

</div>
