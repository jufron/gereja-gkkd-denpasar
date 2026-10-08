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

    {{-- Tabel Badge --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Badge Kategori Jadwal</h3>
                <p class="text-xs text-muted">Total {{ $this->badges->count() }} badge. Dipakai sebagai label pada kartu jadwal.</p>
            </div>
            <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">Tambah Badge</x-be.button>
        </div>

        @if ($this->badges->isEmpty())
            <x-be.empty-state
                icon="fa-tags"
                title="Belum ada badge"
                description="Tambahkan badge pertama untuk memberi label kategori pada jadwal."
            />
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Badge</th>
                            <th class="px-6 py-3.5">Slug</th>
                            <th class="px-6 py-3.5">Jumlah Jadwal</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->badges as $badge)
                            <tr class="transition-colors hover:bg-ink/[0.02]">
                                <td class="px-6 py-4">
                                    <span class="be-badge {{ $badge->color }}">{{ $badge->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="rounded-md bg-ink/5 px-2 py-1 text-[11px] text-muted">{{ $badge->slug }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <x-be.badge tone="neutral">{{ $badge->schedules_count }} jadwal</x-be.badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="bukaFormUbah({{ $badge->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Ubah badge"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $badge->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus badge"
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

    {{-- Modal form tambah/ubah badge --}}
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
            class="flex max-h-[90vh] w-full max-w-md flex-col rounded-3xl bg-card shadow-2xl"
            x-on:click.outside="open = false"
        >
            <div class="flex items-center justify-between border-b border-line p-6">
                <div>
                    <h3 class="text-base font-bold text-ink">{{ $badgeId ? 'Ubah Badge' : 'Tambah Badge Baru' }}</h3>
                    <p class="text-xs text-muted">Label kategori untuk kartu jadwal.</p>
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
                <x-be.field label="Nama Badge" for="name" :help="$errors->first('name')">
                    <input
                        id="name"
                        type="text"
                        wire:model="name"
                        placeholder="Contoh: Tim Pelayanan"
                        class="be-input {{ $errors->has('name') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Warna Badge" for="color" :help="$errors->first('color')">
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($this->colorOptions() as $label => $classes)
                            <label
                                class="flex cursor-pointer items-center gap-2 rounded-xl border p-2.5 text-xs font-medium transition-colors
                                    {{ $color === $classes ? 'border-accent bg-accent/[0.06]' : 'border-line hover:border-ink/20' }}"
                            >
                                <input type="radio" wire:model="color" value="{{ $classes }}" class="sr-only">
                                <span class="be-badge {{ $classes }}">Aa</span>
                                <span class="text-ink">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </x-be.field>

                <div class="flex items-center justify-end gap-2.5 border-t border-line pt-5">
                    <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check">{{ $badgeId ? 'Simpan' : 'Tambah Badge' }}</x-be.button>
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
                    <h3 class="text-base font-bold text-ink">Hapus Badge?</h3>
                    <p class="text-sm text-muted">
                        Badge akan dihapus permanen. Badge yang masih dipakai jadwal tidak bisa dihapus.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">Hapus Badge</x-be.button>
            </div>
        </div>
    </div>

</div>
