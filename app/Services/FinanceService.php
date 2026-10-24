<?php

namespace App\Services;

use App\Contracts\Services\FinanceServiceInterface;
use App\Models\FinanceTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Implementasi layanan keuangan gereja.
 *
 * Semua perhitungan hanya menghitung transaksi berstatus `posted`;
 * transaksi `void` sengaja dikeluarkan namun tetap tersimpan di database.
 */
final class FinanceService implements FinanceServiceInterface
{
    public function paginate(string $tipe, array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $cari = trim((string) ($filters['cari'] ?? ''));
        $kategoriId = isset($filters['kategoriFilter']) && $filters['kategoriFilter'] !== ''
            ? (int) $filters['kategoriFilter']
            : null;
        $dari = trim((string) ($filters['dari'] ?? ''));
        $sampai = trim((string) ($filters['sampai'] ?? ''));

        return FinanceTransaction::query()
            ->whereHas('category', fn ($q) => $q->ofType($tipe))
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('description', 'like', "%{$cari}%")
                    ->orWhere('reference_no', 'like', "%{$cari}%");
            }))
            ->when($kategoriId, fn ($q) => $q->where('finance_category_id', $kategoriId))
            ->when($dari !== '', fn ($q) => $q->whereDate('transaction_date', '>=', $dari))
            ->when($sampai !== '', fn ($q) => $q->whereDate('transaction_date', '<=', $sampai))
            ->with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->paginate($perPage);
    }

    public function total(string $tipe, ?string $dari = null, ?string $sampai = null): int
    {
        return (int) FinanceTransaction::query()
            ->posted()
            ->whereHas('category', fn ($q) => $q->ofType($tipe))
            ->when($dari, fn ($q) => $q->whereDate('transaction_date', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('transaction_date', '<=', $sampai))
            ->sum('amount');
    }

    public function saldo(?string $dari = null, ?string $sampai = null): int
    {
        return $this->total('income', $dari, $sampai) - $this->total('expense', $dari, $sampai);
    }

    public function ringkasan(?string $dari = null, ?string $sampai = null): array
    {
        return [
            'masuk' => $this->total('income', $dari, $sampai),
            'keluar' => $this->total('expense', $dari, $sampai),
            'saldo' => $this->saldo($dari, $sampai),
        ];
    }

    public function create(array $data): FinanceTransaction
    {
        return FinanceTransaction::create([
            'finance_category_id' => $data['finance_category_id'],
            'transaction_date' => $data['transaction_date'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'reference_no' => $data['reference_no'] ?? null,
            'status' => 'posted',
            'created_by' => auth()->id(),
        ]);
    }

    public function update(FinanceTransaction $transaction, array $data): FinanceTransaction
    {
        abort_if($transaction->status === 'void', 422, 'Transaksi yang sudah di-void tidak dapat diubah.');

        $transaction->update([
            'finance_category_id' => $data['finance_category_id'],
            'transaction_date' => $data['transaction_date'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'reference_no' => $data['reference_no'] ?? null,
        ]);

        return $transaction;
    }

    public function void(FinanceTransaction $transaction, string $alasan): FinanceTransaction
    {
        abort_if($transaction->status === 'void', 422, 'Transaksi sudah di-void.');

        $transaction->update([
            'status' => 'void',
            'voided_at' => now(),
            'void_reason' => $alasan,
        ]);

        return $transaction;
    }
}
