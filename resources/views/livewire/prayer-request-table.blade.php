<div class="space-y-6">

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Baru', 'value' => $this->statistik['baru'], 'icon' => 'fa-inbox', 'tone' => 'accent'],
            ['label' => 'Diproses', 'value' => $this->statistik['diproses'], 'icon' => 'fa-hourglass-half', 'tone' => 'warning'],
            ['label' => 'Sudah Didoakan', 'value' => $this->statistik['selesai'], 'icon' => 'fa-circle-check', 'tone' => 'success'],
            ['label' => 'Terhapus', 'value' => $this->statistik['terhapus'], 'icon' => 'fa-trash-can', 'tone' => 'danger'],
        ] as $stat)
            @php
                $tones = [
                    'accent' => 'bg-accent/10 text-accent',
                    'success' => 'bg-success/15 text-success',
                    'warning' => 'bg-warning/15 text-warning',
                    'danger' => 'bg-danger/15 text-danger',
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

    {{-- Tabel Permohonan Doa --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 lg:flex-row lg:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Daftar Permohonan Doa</h3>
                <p class="text-xs text-muted">Kelola permohonan doa — ubah status atau hapus.</p>
            </div>

            <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="cari"
                        placeholder="Cari nama / HP / isi..."
                        class="w-full rounded-full border border-line bg-surface py-2 pl-9 pr-4 text-sm text-ink placeholder:text-muted focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30 sm:w-56"
                    >
                </div>

                <select wire:model.live="filterStatus" class="rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                    <option value="">Semua Status</option>
                    @foreach (\App\Models\PrayerRequest::STATUS as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                    <option value="terhapus">Terhapus</option>
                </select>

                <select wire:model.live="filterKategori" class="rounded-full border border-line bg-surface px-3.5 py-2 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/30">
                    <option value="">Semua Kategori</option>
                    @foreach (\App\Models\PrayerRequest::KATEGORI as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <button wire:click="resetFilter" class="rounded-full border border-line px-3.5 py-2 text-sm font-medium text-muted transition-colors hover:bg-ink/5">
                    Reset
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="bg-ink/[0.03] text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">Kontak</th>
                        <th class="px-5 py-3 font-semibold">Kategori</th>
                        <th class="px-5 py-3 font-semibold">Isi Doa</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($this->doa as $doa)
                        <tr class="hover:bg-ink/[0.02]">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-ink">{{ $doa->nama_lengkap }}</p>
                                <p class="text-xs text-muted">{{ $doa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-ink">{{ $doa->nomor_hp }}</p>
                                <p class="text-xs text-muted">{{ $doa->boleh_dihubungi ? 'Boleh dihubungi' : 'Jangan hubungi' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-accent/10 px-2.5 py-1 text-xs font-semibold text-accent dark:text-accent-soft">
                                    {{ $doa->kategori_label }}
                                </span>
                            </td>
                            <td class="max-w-[220px] px-5 py-4">
                                <p class="truncate text-muted">{{ $doa->isi_doa }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @if ($doa->trashed())
                                    <span class="rounded-full border border-line bg-surface px-2.5 py-1 text-xs font-semibold text-muted">Terhapus</span>
                                @else
                                    <select
                                        wire:change="updateStatus({{ $doa->id }}, $event.target.value)"
                                        class="rounded-full border px-2.5 py-1 text-xs font-semibold
                                            {{ $doa->status === 'selesai'
                                                ? 'border-success/40 bg-success/10 text-success'
                                                : ($doa->status === 'diproses'
                                                    ? 'border-warning/40 bg-warning/10 text-warning'
                                                    : 'border-line bg-surface text-muted') }}"
                                    >
                                        @foreach (\App\Models\PrayerRequest::STATUS as $key => $label)
                                            <option value="{{ $key }}" @selected($doa->status === $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs text-muted">{{ $doa->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($doa->trashed())
                                        <button
                                            wire:click="restore({{ $doa->id }})"
                                            class="rounded-full border border-line px-3 py-1.5 text-xs font-medium text-ink transition-colors hover:border-accent hover:text-accent"
                                        >
                                            Pulihkan
                                        </button>
                                        <button
                                            wire:click="bukaKonfirmasiHapusPermanen({{ $doa->id }})"
                                            class="rounded-full border border-danger/30 px-3 py-1.5 text-xs font-medium text-danger transition-colors hover:bg-danger/10"
                                        >
                                            Hapus Permanen
                                        </button>
                                    @else
                                        <a
                                            href="{{ route('admin.doa.show', $doa) }}"
                                            class="rounded-full border border-line px-3 py-1.5 text-xs font-medium text-ink transition-colors hover:border-accent hover:text-accent"
                                        >
                                            Detail
                                        </a>
                                        <button
                                            wire:click="bukaKonfirmasiHapus({{ $doa->id }})"
                                            class="rounded-full border border-danger/30 px-3 py-1.5 text-xs font-medium text-danger transition-colors hover:bg-danger/10"
                                        >
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-muted">
                                <i class="fa-solid fa-hands-praying text-2xl text-line"></i>
                                <p class="mt-3">Belum ada permohonan doa.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($this->doa->hasPages())
            <div class="border-t border-line p-5">
                {{ $this->doa->links() }}
            </div>
        @endif
    </x-be.card>

    {{-- Modal Konfirmasi Hapus (soft) --}}
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
                    <i class="fa-solid fa-hands-praying"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-ink">Hapus Permohonan Doa?</h3>
                    <p class="text-sm text-muted">
                        Permohonan dari <span class="font-medium text-ink">{{ $hapusNama }}</span>
                        akan dipindahkan ke keranjang sampah.
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

    {{-- Modal Konfirmasi Hapus Permanen --}}
    <div
        x-data="{ open: @entangle('hapusPermanenOpen') }"
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
                    <h3 class="text-base font-bold text-ink">Hapus Permanen?</h3>
                    <p class="text-sm text-muted">
                        Data doa dari <span class="font-medium text-ink">{{ $hapusNama }}</span>
                        akan dihapus permanen dan tidak dapat dipulihkan.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapusPermanen">
                    <span wire:loading.remove wire:target="hapusPermanen">Hapus Permanen</span>
                    <span wire:loading wire:target="hapusPermanen">Menghapus...</span>
                </x-be.button>
            </div>
        </div>
    </div>
</div>
