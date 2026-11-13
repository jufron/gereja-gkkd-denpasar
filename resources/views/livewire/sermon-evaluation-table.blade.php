<div class="space-y-6">

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @php $stats = $this->statistik; @endphp
        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-accent/10 text-accent">
                <i class="fa-solid fa-clipboard-list"></i>
            </span>
            <div>
                <p class="text-2xl font-bold leading-none text-ink">{{ $stats['total'] }}</p>
                <p class="mt-1.5 text-xs text-muted">Total Evaluasi</p>
            </div>
        </x-be.card>

        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-success/15 text-success">
                <i class="fa-solid fa-star"></i>
            </span>
            <div>
                <p class="text-2xl font-bold leading-none text-ink">{{ $stats['rataRata'] }} <span class="text-sm font-medium text-muted">/ 5</span></p>
                <p class="mt-1.5 text-xs text-muted">Rata-rata Rating</p>
            </div>
        </x-be.card>

        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-warning/15 text-warning">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
            <div class="min-w-0">
                <p class="truncate text-base font-bold leading-tight text-ink">{{ $stats['periode'] }}</p>
                <p class="mt-1.5 text-xs text-muted">Periode Filter</p>
            </div>
        </x-be.card>
    </div>

    {{-- Bar distribusi rating --}}
    <x-be.card>
        <div class="p-5">
            <h3 class="text-sm font-bold text-ink">Distribusi Penilaian</h3>
            <div class="mt-4 space-y-2.5">
                @foreach ($stats['distribusi'] as $nilai => $jumlah)
                    @php
                        $persen = $stats['total'] > 0 ? round(($jumlah / $stats['total']) * 100) : 0;
                        $tone = $nilai >= 4 ? 'bg-success' : ($nilai === 3 ? 'bg-warning' : 'bg-danger');
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="w-8 shrink-0 text-right text-xs font-semibold text-ink">{{ $nilai }}★</span>
                        <div class="flex-1">
                            <div
                                class="h-2.5 overflow-hidden rounded-full bg-ink/5"
                                role="img"
                                aria-label="{{ $jumlah }} dari {{ $stats['total'] }} menilai {{ $nilai }} bintang"
                            >
                                <div class="h-full rounded-full {{ $tone }}" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                        <span class="w-10 shrink-0 text-xs text-muted">{{ $jumlah }} · {{ $persen }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </x-be.card>

    {{-- Tabel Evaluasi --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 lg:flex-row lg:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Daftar Evaluasi</h3>
                <p class="text-xs text-muted">Kelola evaluasi khotbah bulanan.</p>
            </div>

            <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="cari"
                        placeholder="Cari nama..."
                        class="w-full rounded-full border border-line bg-surface py-2 pl-9 pr-4 text-sm text-ink placeholder:text-muted focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30 sm:w-44"
                    >
                </div>

                <select wire:model.live="bulan" class="rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                    <option value="">Semua Bulan</option>
                    @foreach (\App\Models\SermonEvaluation::BULAN as $nomor => $nama)
                        <option value="{{ $nomor }}">{{ $nama }}</option>
                    @endforeach
                </select>

                <select wire:model.live="tahun" class="rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                    <option value="">Semua Tahun</option>
                    @php $thn = (int) now()->year; @endphp
                    @for ($t = $thn + 1; $t >= $thn - 1; $t--)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endfor
                </select>

                <select wire:model.live="rating" class="rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                    <option value="">Semua Rating</option>
                    @for ($r = 1; $r <= 5; $r++)
                        <option value="{{ $r }}">{{ $r }}★</option>
                    @endfor
                </select>

                <button wire:click="resetFilter" class="rounded-full border border-line px-3.5 py-2 text-sm font-medium text-muted transition-colors hover:bg-ink/5">
                    Reset
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-ink/[0.03] text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">Periode</th>
                        <th class="px-5 py-3 font-semibold">Rating</th>
                        <th class="px-5 py-3 font-semibold">Masukan</th>
                        <th class="px-5 py-3 font-semibold">Tanggal Masuk</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($this->evaluasi as $item)
                        <tr class="hover:bg-ink/[0.02]">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-ink">{{ $item->nama ?: 'Anonim' }}</p>
                            </td>
                            <td class="px-5 py-4 text-muted">
                                {{ \App\Models\SermonEvaluation::BULAN[$item->bulan] ?? $item->bulan }} {{ $item->tahun }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $item->rating >= 4
                                        ? 'bg-success/15 text-success'
                                        : ($item->rating === 3
                                            ? 'bg-warning/15 text-warning'
                                            : 'bg-danger/15 text-danger') }}">
                                    {{ $item->rating }}★
                                </span>
                            </td>
                            <td class="max-w-[220px] px-5 py-4">
                                <p class="truncate text-muted">{{ $item->masukan ?: $item->berkesan ?: '—' }}</p>
                            </td>
                            <td class="px-5 py-4 text-xs text-muted">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.evaluasi-khotbah.show', $item) }}"
                                        class="rounded-full border border-line px-3 py-1.5 text-xs font-medium text-ink transition-colors hover:border-accent hover:text-accent"
                                    >
                                        Detail
                                    </a>
                                    <button
                                        wire:click="bukaKonfirmasiHapus({{ $item->id }})"
                                        class="rounded-full border border-danger/30 px-3 py-1.5 text-xs font-medium text-danger transition-colors hover:bg-danger/10"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-muted">
                                <i class="fa-solid fa-star text-2xl text-line"></i>
                                <p class="mt-3">Belum ada evaluasi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($this->evaluasi->hasPages())
            <div class="border-t border-line p-5">
                {{ $this->evaluasi->links() }}
            </div>
        @endif
    </x-be.card>

    {{-- Modal Konfirmasi Hapus --}}
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
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-ink">Hapus Evaluasi?</h3>
                    <p class="text-sm text-muted">
                        Data evaluasi akan dihapus permanen dan tidak dapat dipulihkan.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">
                    <span wire:loading.remove wire:target="hapus">Hapus</span>
                    <span wire:loading wire:target="hapus">Menghapus...</span>
                </x-be.button>
            </div>
        </div>
    </div>
</div>
