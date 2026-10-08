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

    {{-- Tabel Jadwal --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Daftar Jadwal</h3>
                <p class="text-xs text-muted">Total {{ $this->schedules->count() }} jadwal. Urutan tampil mengikuti kolom urutan.</p>
            </div>
            <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah" :disabled="$this->badges->isEmpty()">
                Tambah Jadwal
            </x-be.button>
        </div>

        @if ($this->badges->isEmpty())
            <x-be.empty-state
                icon="fa-tags"
                title="Badge belum tersedia"
                description="Tambahkan minimal satu badge terlebih dahulu sebelum membuat jadwal."
            />
        @elseif ($this->schedules->isEmpty())
            <x-be.empty-state
                icon="fa-calendar-days"
                title="Belum ada jadwal"
                description="Tambahkan jadwal pertama untuk ditampilkan di halaman utama."
            />
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Jadwal</th>
                            <th class="px-6 py-3.5">Urutan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->schedules as $schedule)
                            <tr class="transition-colors hover:bg-ink/[0.02]">
                                <td class="px-6 py-4">
                                    <span class="be-badge {{ $schedule->badge?->color ?? 'bg-ink/10 text-ink/70' }}">
                                        {{ $schedule->badge?->name ?? 'Tanpa badge' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-ink">{{ $schedule->title }}</p>
                                    <p class="mt-0.5 text-[11px] text-muted">
                                        {{ $schedule->day }} &bull; {{ $schedule->time }}
                                    </p>
                                    <p class="mt-1 max-w-md text-[11px] text-muted">{{ $schedule->description }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <x-be.badge tone="neutral">{{ $schedule->sort_order }}</x-be.badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-be.toggle
                                            :checked="$schedule->is_active"
                                            wire:click="toggleAktif({{ $schedule->id }})"
                                            aria-label="Ubah status jadwal"
                                        />
                                        <span class="text-[11px] {{ $schedule->is_active ? 'text-success' : 'text-muted' }}">
                                            {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="bukaFormUbah({{ $schedule->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                            aria-label="Ubah jadwal"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $schedule->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus jadwal"
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

    {{-- Modal form tambah/ubah jadwal --}}
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
                    <h3 class="text-base font-bold text-ink">{{ $scheduleId ? 'Ubah Jadwal' : 'Tambah Jadwal Baru' }}</h3>
                    <p class="text-xs text-muted">Informasi ini tampil sebagai kartu di halaman utama.</p>
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
                <x-be.field label="Kategori Badge" for="badgeId" :help="$errors->first('badgeId')">
                    <select id="badgeId" wire:model="badgeId" class="be-input {{ $errors->has('badgeId') ? 'border-danger' : '' }}">
                        <option value="">Pilih badge...</option>
                        @foreach ($this->badges as $badge)
                            <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                        @endforeach
                    </select>
                </x-be.field>

                <x-be.field label="Nama Kegiatan" for="title" :help="$errors->first('title')">
                    <input
                        id="title"
                        type="text"
                        wire:model="title"
                        placeholder="Contoh: Komsel"
                        class="be-input {{ $errors->has('title') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-be.field label="Hari" for="day" :help="$errors->first('day')">
                        <input
                            id="day"
                            type="text"
                            wire:model="day"
                            placeholder="Contoh: Kamis / Jumat"
                            class="be-input {{ $errors->has('day') ? 'border-danger' : '' }}"
                        >
                    </x-be.field>

                    <x-be.field label="Waktu" for="time" :help="$errors->first('time')">
                        <input
                            id="time"
                            type="text"
                            wire:model="time"
                            placeholder="Contoh: Pukul 19.30 WITA"
                            class="be-input {{ $errors->has('time') ? 'border-danger' : '' }}"
                        >
                    </x-be.field>
                </div>

                <x-be.field label="Deskripsi" for="description" :help="$errors->first('description')">
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="3"
                        placeholder="Jelaskan kegiatan ini secara singkat."
                        class="be-input h-auto py-2.5 {{ $errors->has('description') ? 'border-danger' : '' }}"
                    ></textarea>
                </x-be.field>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-be.field label="Urutan Tampil" for="sortOrder" hint="Angka kecil tampil lebih dulu." :help="$errors->first('sortOrder')">
                        <input
                            id="sortOrder"
                            type="number"
                            min="0"
                            wire:model="sortOrder"
                            class="be-input {{ $errors->has('sortOrder') ? 'border-danger' : '' }}"
                        >
                    </x-be.field>

                    <div class="space-y-1.5">
                        <span class="be-label">Status</span>
                        <div class="flex h-11 items-center gap-3">
                            <x-be.toggle :checked="$isActive" wire:click="$toggle('isActive')" />
                            <span class="text-xs font-medium text-muted">{{ $isActive ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 border-t border-line pt-5">
                    <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check">{{ $scheduleId ? 'Simpan' : 'Tambah Jadwal' }}</x-be.button>
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
                    <h3 class="text-base font-bold text-ink">Hapus Jadwal?</h3>
                    <p class="text-sm text-muted">
                        Jadwal yang dipilih akan dihapus permanen dari halaman utama.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapus">Hapus Jadwal</x-be.button>
            </div>
        </div>
    </div>

</div>
