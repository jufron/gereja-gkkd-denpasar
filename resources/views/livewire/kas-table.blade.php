<div class="space-y-6" x-data="{ modalOpen: @entangle('modalOpen'), modalVoidOpen: @entangle('modalVoidOpen') }">

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

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @php
            $isIncome = $tipe === 'income';
            $tone = $isIncome ? 'success' : 'danger';
            $toneClass = $isIncome ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger';
            $icon = $isIncome ? 'fa-arrow-down-to-line' : 'fa-arrow-up-from-line';
            $label = $isIncome ? 'Total Masuk (periode)' : 'Total Keluar (periode)';
        @endphp

        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $toneClass }}">
                <i class="fa-solid {{ $icon }}"></i>
            </span>
            <div class="min-w-0">
                <p class="truncate text-2xl font-bold leading-none text-ink">
                    {{ \Illuminate\Support\Number::currency($this->totalPeriode, 'IDR', 'id') }}
                </p>
                <p class="mt-1.5 text-xs text-muted">{{ $label }}</p>
            </div>
        </x-be.card>

        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-accent/10 text-accent">
                <i class="fa-solid fa-layer-group"></i>
            </span>
            <div class="min-w-0">
                <p class="text-2xl font-bold leading-none text-ink">{{ $this->transaksi->total() }}</p>
                <p class="mt-1.5 text-xs text-muted">Jumlah Transaksi</p>
            </div>
        </x-be.card>

        <x-be.card class="flex items-center gap-4 p-5">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-warning/15 text-warning">
                <i class="fa-solid fa-scale-balanced"></i>
            </span>
            <div class="min-w-0">
                <p class="truncate text-2xl font-bold leading-none text-ink">
                    {{ \Illuminate\Support\Number::currency($this->ringkasan['saldo'], 'IDR', 'id') }}
                </p>
                <p class="mt-1.5 text-xs text-muted">Saldo Kas</p>
            </div>
        </x-be.card>
    </div>

    {{-- Kartu tabel --}}
    <x-be.card class="overflow-hidden">
        {{-- Header + filter --}}
        <div class="flex flex-col gap-4 border-b border-line p-5">
            <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                <div>
                    <h3 class="text-base font-bold text-ink">{{ $isIncome ? 'Daftar Kas Masuk' : 'Daftar Kas Keluar' }}</h3>
                    <p class="text-xs text-muted">Semua transaksi dihitung dari yang terbaru.</p>
                </div>

                <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">
                    Tambah {{ $isIncome ? 'Kas Masuk' : 'Kas Keluar' }}
                </x-be.button>
            </div>

            {{-- Filter bar --}}
            <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="f-dari" class="be-label">Dari</label>
                    <input id="f-dari" type="date" wire:model.live="dari" class="be-input">
                </div>
                <div>
                    <label for="f-sampai" class="be-label">Sampai</label>
                    <input id="f-sampai" type="date" wire:model.live="sampai" class="be-input">
                </div>
                <div>
                    <label for="f-kategori" class="be-label">Kategori</label>
                    <select id="f-kategori" wire:model.live="kategoriFilter" class="be-input">
                        <option value="">Semua kategori</option>
                        @foreach ($this->kategoriOptions as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="f-cari" class="be-label">Pencarian</label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                        <input
                            id="f-cari"
                            type="search"
                            wire:model.live.debounce.300ms="cari"
                            placeholder="Keterangan / bukti..."
                            aria-label="Cari transaksi"
                            class="be-input pl-9"
                        >
                    </div>
                </div>
            </div>

            @if ($cari !== '' || $kategoriFilter !== '' || $dari !== '' || $sampai !== '')
                <div class="flex justify-end">
                    <x-be.button type="button" variant="ghost" icon="fa-rotate-left" wire:click="resetFilter">Reset Filter</x-be.button>
                </div>
            @endif
        </div>

        {{-- Tabel --}}
        @if ($this->transaksi->isEmpty())
            <x-be.empty-state
                icon="{{ $isIncome ? 'fa-arrow-down-to-line' : 'fa-arrow-up-from-line' }}"
                title="{{ $this->transaksi->total() === 0 ? 'Belum ada transaksi' : 'Tidak ada hasil' }}"
                description="{{ $this->transaksi->total() === 0
                    ? ($isIncome ? 'Catat pemasukan pertama gereja.' : 'Catat pengeluaran pertama gereja.')
                    : 'Coba ubah kata kunci, periode, atau reset filter.' }}"
            >
                @if ($this->transaksi->total() === 0)
                    <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">
                        Tambah {{ $isIncome ? 'Kas Masuk' : 'Kas Keluar' }}
                    </x-be.button>
                @endif
            </x-be.empty-state>
        @else
            <div class="w-full overflow-x-auto" tabindex="0" aria-label="Tabel transaksi, dapat digulir secara horizontal">
                <table class="w-full border-collapse text-left">
                    <caption class="sr-only">{{ $isIncome ? 'Daftar kas masuk' : 'Daftar kas keluar' }}</caption>
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th scope="col" class="px-6 py-3.5">Tanggal</th>
                            <th scope="col" class="px-6 py-3.5">Keterangan</th>
                            <th scope="col" class="px-6 py-3.5">Kategori</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Jumlah</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->transaksi as $tx)
                            <tr class="transition-colors hover:bg-ink/[0.02]" wire:key="tx-{{ $tx->id }}">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="font-medium text-ink">{{ $tx->transaction_date->translatedFormat('d M Y') }}</span>
                                </td>
                                <td class="max-w-xs px-6 py-4">
                                    <p class="font-medium text-ink {{ $tx->status === 'void' ? 'line-through text-muted' : '' }}">{{ $tx->description }}</p>
                                    @if ($tx->reference_no)
                                        <p class="text-[11px] text-muted">Bukti: {{ $tx->reference_no }}</p>
                                    @endif
                                    @if ($tx->status === 'void')
                                        <p class="mt-0.5 text-[11px] italic text-danger">{{ $tx->void_reason }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="be-badge bg-ink/5 text-muted">{{ $tx->category?->name }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <span class="font-semibold tabular-nums {{ $tx->status === 'void' ? 'text-muted line-through' : ($isIncome ? 'text-success' : 'text-danger') }}">
                                        {{ $isIncome ? '+' : '−' }}{{ \Illuminate\Support\Number::currency($tx->amount, 'IDR', 'id') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($tx->status !== 'void')
                                            <button
                                                type="button"
                                                wire:click="bukaFormUbah({{ $tx->id }})"
                                                class="inline-flex h-11 min-w-11 items-center justify-center rounded-xl border border-line px-3 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                                aria-label="Ubah transaksi {{ $tx->transaction_date->format('d M') }}"
                                                title="Ubah"
                                            >
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="bukaVoid({{ $tx->id }})"
                                                class="inline-flex h-11 min-w-11 items-center justify-center rounded-xl border border-line px-3 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                                aria-label="Void transaksi {{ $tx->transaction_date->format('d M') }}"
                                                title="Void"
                                            >
                                                <i class="fa-solid fa-ban text-[10px]"></i>
                                            </button>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-danger/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-danger">
                                                <i class="fa-solid fa-ban"></i> Void
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-line px-6 py-4 text-xs text-muted sm:flex-row sm:items-center sm:justify-between">
                <span>Menampilkan {{ $this->transaksi->firstItem() ?? 0 }}–{{ $this->transaksi->lastItem() ?? 0 }} dari {{ $this->transaksi->total() }} transaksi</span>
                <div class="flex items-center gap-1">
                    {{ $this->transaksi->links() }}
                </div>
            </div>
        @endif
    </x-be.card>

    {{-- Modal form tambah/ubah --}}
    <div
        x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:keydown.escape.window="modalOpen = false"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
        style="display: none;"
    >
        <div
            x-show="modalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="flex max-h-[90vh] w-full max-w-lg flex-col rounded-3xl bg-card shadow-2xl"
            x-on:click.outside="modalOpen = false"
            role="dialog"
            aria-modal="true"
            aria-labelledby="judul-modal-kas"
        >
            <div class="flex items-center justify-between border-b border-line p-6">
                <div>
                    <h3 id="judul-modal-kas" class="text-base font-bold text-ink">
                        {{ $editId ? 'Ubah Transaksi' : 'Tambah '.($isIncome ? 'Kas Masuk' : 'Kas Keluar') }}
                    </h3>
                    <p class="text-xs text-muted">{{ $isIncome ? 'Catat pemasukan.' : 'Catat pengeluaran.' }}</p>
                </div>
                <button type="button" x-on:click="modalOpen = false" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form wire:submit="simpan" class="space-y-5 overflow-y-auto p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-be.field label="Tanggal" for="transactionDate" :help="$errors->first('transactionDate')">
                        <input id="transactionDate" type="date" wire:model="transactionDate" class="be-input {{ $errors->has('transactionDate') ? 'border-danger' : '' }}">
                    </x-be.field>

                    <x-be.field label="Kategori" for="financeCategoryId" :help="$errors->first('financeCategoryId')">
                        <select id="financeCategoryId" wire:model="financeCategoryId" class="be-input {{ $errors->has('financeCategoryId') ? 'border-danger' : '' }}">
                            <option value="">Pilih kategori...</option>
                            @foreach ($this->kategoriOptions as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </x-be.field>
                </div>

                <x-be.field label="Jumlah" for="amount" :help="$errors->first('amount')" hint="Contoh: 1.500.000">
                    <input
                        id="amount"
                        type="text"
                        inputmode="numeric"
                        wire:model="amount"
                        placeholder="0"
                        class="be-input tabular-nums {{ $errors->has('amount') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Keterangan" for="description" :help="$errors->first('description')">
                    <input
                        id="description"
                        type="text"
                        wire:model="description"
                        placeholder="{{ $isIncome ? 'Contoh: Persembahan Ibadah Minggu' : 'Contoh: Tagihan listrik & air' }}"
                        class="be-input {{ $errors->has('description') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <x-be.field label="Nomor Bukti" for="referenceNo" :help="$errors->first('referenceNo')" hint="Opsional — kwitansi / bukti transfer.">
                    <input id="referenceNo" type="text" wire:model="referenceNo" placeholder="Contoh: KW-2026-001" class="be-input {{ $errors->has('referenceNo') ? 'border-danger' : '' }}">
                </x-be.field>

                @if ($errors->any())
                    <div class="rounded-xl border border-danger/30 bg-danger/10 p-3 text-xs text-danger" role="alert">
                        <p class="font-semibold">Perbaiki beberapa hal berikut:</p>
                        <ul class="mt-1 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-end gap-2.5 border-t border-line pt-5">
                    <x-be.button type="button" variant="ghost" x-on:click="modalOpen = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check" wire:loading.attr="disabled" wire:target="simpan">
                        <span wire:loading.remove wire:target="simpan">{{ $editId ? 'Simpan' : 'Tambah Transaksi' }}</span>
                        <span wire:loading wire:target="simpan">Menyimpan...</span>
                    </x-be.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal void --}}
    <div
        x-show="modalVoidOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:keydown.escape.window="modalVoidOpen = false"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
        style="display: none;"
    >
        <div
            x-show="modalVoidOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-md rounded-3xl bg-card p-6 shadow-2xl"
            x-on:click.outside="modalVoidOpen = false"
            role="dialog"
            aria-modal="true"
            aria-labelledby="judul-modal-void"
        >
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                    <i class="fa-solid fa-ban"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 id="judul-modal-void" class="text-base font-bold text-ink">Void Transaksi</h3>
                    <p class="text-sm text-muted">
                        Transaksi tetap tersimpan untuk jejak audit, tapi dikeluarkan dari laporan dan saldo.
                    </p>
                </div>
            </div>

            <form wire:submit="void" class="mt-5 space-y-5">
                <x-be.field label="Alasan Void" for="voidReason" :help="$errors->first('voidReason')">
                    <textarea
                        id="voidReason"
                        wire:model="voidReason"
                        rows="3"
                        placeholder="Contoh: Salah nominal, dicatat ganda."
                        class="be-input !h-auto py-2.5 {{ $errors->has('voidReason') ? 'border-danger' : '' }}"
                    ></textarea>
                </x-be.field>

                <div class="flex items-center justify-end gap-2.5">
                    <x-be.button type="button" variant="ghost" x-on:click="modalVoidOpen = false">Batal</x-be.button>
                    <x-be.button type="submit" variant="danger" icon="fa-ban" wire:loading.attr="disabled" wire:target="void">
                        <span wire:loading.remove wire:target="void">Void Transaksi</span>
                        <span wire:loading wire:target="void">Memproses...</span>
                    </x-be.button>
                </div>
            </form>
        </div>
    </div>

</div>
