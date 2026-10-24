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

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @foreach ([
            ['label' => 'Total Berita', 'value' => $this->statistik['total'], 'icon' => 'fa-newspaper', 'tone' => 'accent'],
            ['label' => 'Diterbitkan', 'value' => $this->statistik['published'], 'icon' => 'fa-circle-check', 'tone' => 'success'],
            ['label' => 'Draft', 'value' => $this->statistik['draft'], 'icon' => 'fa-pen-nib', 'tone' => 'warning'],
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

    {{-- Tabel Berita --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 lg:flex-row lg:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Daftar Berita</h3>
                <p class="text-xs text-muted">Kelola artikel berita — terbitkan, ubah, atau hapus.</p>
            </div>

            <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="cari"
                        placeholder="Cari berita..."
                        aria-label="Cari berita"
                        class="be-input pl-9 sm:w-56"
                    >
                </div>

                <select wire:model.live="filterStatus" aria-label="Filter status" class="be-input sm:w-40">
                    <option value="">Semua status</option>
                    <option value="published">Diterbitkan</option>
                    <option value="draft">Draft</option>
                </select>

                @if ($cari !== '' || $filterStatus !== '')
                    <x-be.button type="button" variant="ghost" icon="fa-rotate-left" wire:click="resetFilter">Reset</x-be.button>
                @endif

                <a href="{{ route('admin.berita.tambah') }}" class="be-btn be-btn-primary">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    Tambah Berita
                </a>
            </div>
        </div>

        @if ($this->berita->isEmpty())
            <x-be.empty-state
                icon="fa-newspaper"
                title="{{ $cari !== '' || $filterStatus !== '' ? 'Berita tidak ditemukan' : 'Belum ada berita' }}"
                description="{{ $cari !== '' || $filterStatus !== ''
                    ? 'Coba ubah kata kunci atau reset filter untuk melihat semua berita.'
                    : 'Tulis artikel pertama untuk memberi kabar kepada jemaat.' }}"
            >
                @if ($cari !== '' || $filterStatus !== '')
                    <x-be.button type="button" variant="ghost" icon="fa-rotate-left" wire:click="resetFilter">Reset Filter</x-be.button>
                @else
                    <a href="{{ route('admin.berita.tambah') }}" class="be-btn be-btn-primary">
                        <i class="fa-solid fa-plus text-[11px]"></i>
                        Tambah Berita
                    </a>
                @endif
            </x-be.empty-state>
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Banner</th>
                            <th class="px-6 py-3.5">Judul</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Dipublikasikan</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->berita as $item)
                            <tr class="transition-colors hover:bg-ink/[0.02]" wire:key="berita-{{ $item->id }}">
                                <td class="px-6 py-4">
                                    @if ($item->featured_image)
                                        <img src="{{ asset('storage/'.$item->featured_image) }}"
                                             class="h-10 w-16 shrink-0 rounded-lg object-cover"
                                             alt="">
                                    @else
                                        <span class="flex h-10 w-16 shrink-0 items-center justify-center rounded-lg bg-ink/5 text-muted">
                                            <i class="fa-solid fa-image"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="max-w-md px-6 py-4">
                                    <p class="font-semibold text-ink">{{ $item->title }}</p>
                                    <p class="truncate text-[11px] text-muted">
                                        {{ $item->excerpt ?: 'Tanpa excerpt' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->category)
                                        <span class="be-badge {{ $item->category->color }}">{{ $item->category->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-start gap-1.5">
                                        <span class="text-[11px] font-semibold {{ $item->status === 'published' ? 'text-success' : 'text-warning' }}">
                                            {{ $item->status === 'published' ? 'Diterbitkan' : 'Draft' }}
                                        </span>
                                        <button
                                            type="button"
                                            wire:click="toggleStatus({{ $item->id }})"
                                            role="switch"
                                            aria-checked="{{ $item->status === 'published' ? 'true' : 'false' }}"
                                            aria-label="{{ $item->status === 'published' ? 'Jadikan draft' : 'Terbitkan' }}"
                                            title="{{ $item->status === 'published' ? 'Jadikan draft' : 'Terbitkan' }}"
                                            class="be-switch bg-ink/20 aria-checked:bg-accent"
                                        ></button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-muted">
                                    {{ $item->published_at?->translatedFormat('d M Y H:i') ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.berita.lihat', $item) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Lihat {{ $item->title }}"
                                            title="Lihat / pratinjau"
                                        >
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                        </a>
                                        <a
                                            href="{{ route('admin.berita.ubah', $item) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Ubah {{ $item->title }}"
                                            title="Ubah"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </a>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $item->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus {{ $item->title }}"
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

            <div class="flex flex-col items-center justify-between gap-3 border-t border-line px-6 py-3.5 text-xs text-muted sm:flex-row">
                <span>
                    Menampilkan {{ $this->berita->total() }} berita
                    (halaman {{ $this->berita->currentPage() }} dari {{ $this->berita->lastPage() }})
                </span>
                {{ $this->berita->links() }}
            </div>
        @endif
    </x-be.card>

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
                    <h3 class="text-base font-bold text-ink">Hapus Berita?</h3>
                    <p class="text-sm text-muted">
                        <span class="font-medium text-ink">"{{ $hapusJudul }}"</span> akan dihapus permanen
                        termasuk banner. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">
                    <span wire:loading.remove wire:target="hapus">Hapus Berita</span>
                    <span wire:loading wire:target="hapus">Menghapus...</span>
                </x-be.button>
            </div>
        </div>
    </div>

</div>
