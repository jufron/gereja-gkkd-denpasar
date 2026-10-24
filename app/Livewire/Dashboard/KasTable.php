<?php

namespace App\Livewire\Dashboard;

use App\Contracts\Services\FinanceServiceInterface;
use App\Models\FinanceCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Komponen tabel kas masuk / kas keluar.
 *
 * Satu komponen dipakai untuk dua halaman (tipe=income | expense).
 * Tipe terkunci (#[Locked]) sehingga pemasukan tidak bisa diisi lewat
 * halaman pengeluaran (dan sebaliknya).
 */
final class KasTable extends Component
{
    /** 'income' | 'expense' — dikunci dari halaman yang memuat komponen. */
    #[Locked]
    public string $tipe;

    // ── Filter ──────────────────────────────────────────────────────────────
    public string $dari = '';
    public string $sampai = '';
    public string $cari = '';
    public string $kategoriFilter = '';

    // ── Form tambah/ubah ────────────────────────────────────────────────────
    public ?int $editId = null;
    public ?int $financeCategoryId = null;
    public string $transactionDate = '';
    public string $amount = '';
    public string $description = '';
    public string $referenceNo = '';

    // ── Modal ───────────────────────────────────────────────────────────────
    public bool $modalOpen = false;
    public bool $modalVoidOpen = false;
    public ?int $voidId = null;
    public string $voidReason = '';

    // ── Notifikasi ──────────────────────────────────────────────────────────
    public ?string $pesan = null;
    public string $pesanTone = 'success';

    public function mount(string $tipe): void
    {
        abort_unless(auth()->user()?->can('Kelola Keuangan'), 403);

        $this->tipe = $tipe;
        $this->dari = now()->startOfMonth()->toDateString();
        $this->sampai = now()->toDateString();
        $this->resetForm();
    }

    private function service(): FinanceServiceInterface
    {
        return app(FinanceServiceInterface::class);
    }

    private function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    public function resetFilter(): void
    {
        $this->reset('cari', 'kategoriFilter');
        $this->dari = now()->startOfMonth()->toDateString();
        $this->sampai = now()->toDateString();
    }

    public function resetForm(): void
    {
        $this->reset('editId', 'financeCategoryId', 'transactionDate', 'amount', 'description', 'referenceNo');
        $this->transactionDate = now()->toDateString();
        $this->resetValidation();
    }

    #[Computed]
    public function ringkasan(): array
    {
        return $this->service()->ringkasan($this->dari ?: null, $this->sampai ?: null);
    }

    #[Computed]
    public function totalPeriode(): int
    {
        return $this->service()->total($this->tipe, $this->dari ?: null, $this->sampai ?: null);
    }

    #[Computed]
    public function transaksi(): LengthAwarePaginator
    {
        return $this->service()->paginate($this->tipe, [
            'cari' => $this->cari,
            'kategoriFilter' => $this->kategoriFilter,
            'dari' => $this->dari,
            'sampai' => $this->sampai,
        ]);
    }

    #[Computed]
    public function kategoriOptions(): Collection
    {
        return FinanceCategory::query()
            ->ofType($this->tipe)
            ->active()
            ->ordered()
            ->get();
    }

    public function bukaFormTambah(): void
    {
        $this->resetForm();
        $this->modalOpen = true;
    }

    public function bukaFormUbah(int $id): void
    {
        $transaction = \App\Models\FinanceTransaction::query()
            ->whereHas('category', fn ($q) => $q->ofType($this->tipe))
            ->findOrFail($id);

        abort_if($transaction->status === 'void', 422, 'Transaksi void tidak dapat diubah.');

        $this->editId = $transaction->id;
        $this->financeCategoryId = $transaction->finance_category_id;
        $this->transactionDate = $transaction->transaction_date->toDateString();
        $this->amount = number_format($transaction->amount, 0, ',', '.');
        $this->description = $transaction->description;
        $this->referenceNo = $transaction->reference_no ?? '';
        $this->resetValidation();
        $this->modalOpen = true;
    }

    public function simpan(): void
    {
        // Bersihkan format ribuan (1.500.000 → 1500000) sebelum validasi.
        $this->amount = preg_replace('/\D/', '', (string) $this->amount);

        $data = $this->validate([
            'financeCategoryId' => ['required', 'integer', 'exists:finance_categories,id'],
            'transactionDate' => ['required', 'date', 'before_or_equal:today'],
            'amount' => ['required', 'integer', 'min:1', 'max:999999999999'],
            'description' => ['required', 'string', 'max:255'],
            'referenceNo' => ['nullable', 'string', 'max:50'],
        ], [], [
            'financeCategoryId' => 'kategori',
            'transactionDate' => 'tanggal',
            'amount' => 'jumlah',
            'description' => 'keterangan',
            'referenceNo' => 'nomor bukti',
        ]);

        // Pastikan kategori sesuai tipe halaman ini (pertahanan kedua).
        $category = FinanceCategory::findOrFail($data['financeCategoryId']);
        abort_unless($category->type === $this->tipe, 422, 'Kategori tidak sesuai dengan halaman ini.');

        $payload = [
            'finance_category_id' => $category->id,
            'transaction_date' => $data['transactionDate'],
            'amount' => (int) $data['amount'],
            'description' => trim($data['description']),
            'reference_no' => trim((string) ($data['referenceNo'] ?? '')) ?: null,
        ];

        if ($this->editId) {
            $transaction = \App\Models\FinanceTransaction::findOrFail($this->editId);
            $this->service()->update($transaction, $payload);
            $this->setPesan('Transaksi berhasil diperbarui.');
        } else {
            $this->service()->create($payload);
            $this->setPesan('Transaksi berhasil dicatat.');
        }

        unset($this->ringkasan, $this->totalPeriode, $this->transaksi);

        $this->resetForm();
        $this->modalOpen = false;
    }

    public function bukaVoid(int $id): void
    {
        $this->voidId = $id;
        $this->voidReason = '';
        $this->resetValidation();
        $this->modalVoidOpen = true;
    }

    public function void(): void
    {
        $data = $this->validate([
            'voidReason' => ['required', 'string', 'max:255'],
        ], [], ['voidReason' => 'alasan void']);

        $transaction = \App\Models\FinanceTransaction::findOrFail($this->voidId);
        $this->service()->void($transaction, trim($data['voidReason']));

        $this->setPesan('Transaksi di-void dan dikeluarkan dari laporan.');

        unset($this->ringkasan, $this->totalPeriode, $this->transaksi);

        $this->modalVoidOpen = false;
        $this->voidId = null;
    }

    public function render()
    {
        return view('livewire.kas-table');
    }
}
