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
            role="status"
        >
            <i class="fa-solid {{ $pesanTone === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' }}"></i>
            <span>{{ $pesan }}</span>
        </div>
    @endif

    {{-- Tab tipe --}}
    <div class="flex items-center justify-between gap-4">
        <div class="inline-flex rounded-xl border border-line bg-card p-1" role="tablist" aria-label="Tipe kategori">
            <button
                type="button"
                role="tab"
                aria-selected="{{ $tipe === 'income' ? 'true' : 'false' }}"
                wire:click="pilihTipe('income')"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors
                    {{ $tipe === 'income' ? 'bg-accent text-white' : 'text-muted hover:text-ink' }}"
            >
                Pemasukan
            </button>
            <button
                type="button"
                role="tab"
                aria-selected="{{ $tipe === 'expense' ? 'true' : 'false' }}"
                wire:click="pilihTipe('expense')"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors
                    {{ $tipe === 'expense' ? 'bg-accent text-white' : 'text-muted hover:text-ink' }}"
            >
                Pengeluaran
            </button>
        </div>

        <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">Tambah Kategori</x-be.button>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @foreach ([
            ['label' => 'Total Kategori', 'value' => $this->statistik['total'], 'icon' => 'fa-tags', 'tone' => 'accent'],
            ['label' => 'Aktif', 'value' => $this->statistik['aktif'], 'icon' => 'fa-circle-check', 'tone' => 'success'],
            ['label' => 'Nonaktif', 'value' => $this->statistik['nonaktif'], 'icon' => 'fa-circle-pause', 'tone' => 'warning'],
        ] as $stat)
            @php
                $tones = [
                    'accent' => 'bg-accent/10 text-accent',
                    'success' => 'bg-success/15 text-success',
                    'warning' => 'bg-warning/15 text-warning',
                ];
            @endphp
            <x-be.card class="flex items-center gap-4 p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $tones[$stat['tone']] }}">
                    <i class="fa-solid {{ $stat['icon'] }}"></i>
                </span>
                <div>
                    <p class="text-2xl font-bold leading-none text-ink">{{ $stat['value'] }}</p>
                    <p class="mt-1.5 text-xs text-muted">{{ $stat['label'] }}</p>
                </div>
            </x-be.card>
        @endforeach
    </div>

    {{-- Tabel kategori --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 lg:flex-row lg:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">{{ $tipe === 'income' ? 'Kategori Pemasukan' : 'Kategori Pengeluaran' }}</h3>
                <p class="text-xs text-muted">Kategori ini dipakai untuk form kas masuk / kas keluar.</p>
            </div>

            <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="cari"
                        placeholder="Cari kategori..."
                        aria-label="Cari kategori"
                        class="be-input pl-9 sm:w-56"
                    >
                </div>

                <select wire:model.live="filterStatus" aria-label="Filter status" class="be-input sm:w-40">
                    <option value="">Semua status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>

                @if ($cari !== '' || $filterStatus !== '')
                    <x-be.button type="button" variant="ghost" icon="fa-rotate-left" wire:click="resetFilter">Reset</x-be.button>
                @endif
            </div>
        </div>

        @if ($this->categories->isEmpty())
            <x-be.empty-state
                icon="fa-tags"
                title="{{ $cari !== '' || $filterStatus !== '' ? 'Kategori tidak ditemukan' : 'Belum ada kategori' }}"
                description="{{ $cari !== '' || $filterStatus !== ''
                    ? 'Coba ubah kata kunci atau reset filter.'
                    : 'Tambahkan kategori untuk tipe ini.' }}"
            >
                @if ($cari !== '' || $filterStatus !== '')
                    <x-be.button type="button" variant="ghost" icon="fa-rotate-left" wire:click="resetFilter">Reset Filter</x-be.button>
                @endif
            </x-be.empty-state>
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <caption class="sr-only">{{ $tipe === 'income' ? 'Kategori pemasukan' : 'Kategori pengeluaran' }}</caption>
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th scope="col" class="px-6 py-3.5">Kategori</th>
                            <th scope="col" class="px-6 py-3.5">Kode</th>
                            <th scope="col" class="px-6 py-3.5">Deskripsi</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Urutan</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->categories as $category)
                            <tr class="transition-colors hover:bg-ink/[0.02]" wire:key="fcat-{{ $category->id }}">
                                <td class="px-6 py-4">
                                    <span class="be-badge bg-ink/5 text-ink">{{ $category->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($category->code)
                                        <code class="rounded-md bg-ink/5 px-2 py-1 text-[11px] text-muted">{{ $category->code }}</code>
                                    @else
                                        <span class="italic text-muted/60">—</span>
                                    @endif
                                </td>
                                <td class="max-w-xs px-6 py-4">
                                    <p class="line-clamp-2 {{ $category->description ? 'text-muted' : 'italic text-muted/60' }}">
                                        {{ $category->description ?: 'Belum ada deskripsi' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-ink">{{ $category->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        type="button"
                                        wire:click="toggleAktif({{ $category->id }})"
                                        role="switch"
                                        aria-checked="{{ $category->is_active ? 'true' : 'false' }}"
                                        title="{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        aria-label="{{ $category->is_active ? 'Nonaktifkan kategori' : 'Aktifkan kategori' }}"
                                        class="be-switch bg-ink/20 aria-checked:bg-accent"
                                    ></button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="bukaFormUbah({{ $category->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Ubah kategori {{ $category->name }}"
                                            title="Ubah"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $category->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus kategori {{ $category->name }}"
                                            title="Hapus"
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

            <div class="border-t border-line px-6 py-3.5 text-xs text-muted">
                Menampilkan {{ $this->categories->count() }} kategori
            </div>
        @endif
    </x-be.card>

    {{-- Modal form tambah/ubah --}}
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
            role="dialog"
            aria-modal="true"
        >
            <div class="flex items-center justify-between border-b border-line p-6">
                <div>
                    <h3 class="text-base font-bold text-ink">{{ $kategoriId ? 'Ubah Kategori Keuangan' : 'Tambah Kategori Baru' }}</h3>
                    <p class="text-xs text-muted">{{ $tipe === 'income' ? 'Kategori pemasukan' : 'Kategori pengeluaran' }}.</p>
                </div>
                <button type="button" x-on:click="open = false" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form wire:submit="simpan" class="space-y-5 overflow-y-auto p-6">
                <x-be.field label="Nama Kategori" for="name" :help="$errors->first('name')">
                    <input
                        id="name"
                        type="text"
                        wire:model="name"
                        placeholder="{{ $tipe === 'income' ? 'Contoh: Persembahan Mingguan' : 'Contoh: Listrik & Air' }}"
                        class="be-input {{ $errors->has('name') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-be.field label="Kode" for="code" :help="$errors->first('code')" hint="Opsional — untuk laporan.">
                        <input id="code" type="text" wire:model="code" placeholder="Contoh: P001" class="be-input {{ $errors->has('code') ? 'border-danger' : '' }}">
                    </x-be.field>

                    <x-be.field label="Urutan Tampil" for="sortOrder" :help="$errors->first('sortOrder')">
                        <input id="sortOrder" type="number" min="0" max="9999" wire:model="sortOrder" class="be-input {{ $errors->has('sortOrder') ? 'border-danger' : '' }}">
                    </x-be.field>
                </div>

                <x-be.field label="Deskripsi" for="description" :help="$errors->first('description')" hint="Opsional — penjelasan singkat kategori.">
                    <textarea id="description" wire:model="description" rows="3" placeholder="Contoh: Persembahan kolekte saat ibadah mingguan." class="be-input !h-auto py-2.5 {{ $errors->has('description') ? 'border-danger' : '' }}"></textarea>
                </x-be.field>

                <x-be.field label="Status" for="isActive" :help="$errors->first('isActive')" hint="Hanya kategori aktif muncul di form kas.">
                    <label class="flex h-11 cursor-pointer items-center gap-2.5 rounded-xl border border-line px-3">
                        <input id="isActive" type="checkbox" wire:model="isActive" class="h-4 w-4 rounded border-line text-accent focus:ring-accent">
                        <span class="text-sm text-ink">Aktifkan kategori</span>
                    </label>
                </x-be.field>

                <div class="flex items-center justify-end gap-2.5 border-t border-line pt-5">
                    <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check" wire:loading.attr="disabled" wire:target="simpan">
                        <span wire:loading.remove wire:target="simpan">{{ $kategoriId ? 'Simpan' : 'Tambah Kategori' }}</span>
                        <span wire:loading wire:target="simpan">Menyimpan...</span>
                    </x-be.button>
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
            role="dialog"
            aria-modal="true"
        >
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-ink">Hapus Kategori Keuangan?</h3>
                    <p class="text-sm text-muted">
                        Kategori yang sudah dipakai transaksi tidak dapat dihapus.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">Hapus Kategori</x-be.button>
            </div>
        </div>
    </div>

</div>
