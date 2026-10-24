<?php

namespace App\Contracts\Services;

use App\Models\FinanceTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Kontrak layanan keuangan gereja (kas masuk / kas keluar).
 *
 * Memusatkan aturan bisnis (tipe turunan dari kategori, void, perhitungan
 * ringkasan) agar dapat diuji dan dipelihara terpusat.
 */
interface FinanceServiceInterface
{
    /**
     * Daftar transaksi terfilter untuk satu tipe (income | expense).
     *
     * @param  string  $tipe  'income' | 'expense'
     * @param  array<string, mixed>  $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(string $tipe, array $filters, int $perPage = 15): LengthAwarePaginator;

    /**
     * Total nominal transaksi posted untuk satu tipe dalam rentang periode.
     */
    public function total(string $tipe, ?string $dari = null, ?string $sampai = null): int;

    /**
     * Selisih masuk dikurangi keluar (hanya transaksi posted).
     */
    public function saldo(?string $dari = null, ?string $sampai = null): int;

    /**
     * Ringkasan masuk, keluar, saldo.
     *
     * @return array{masuk: int, keluar: int, saldo: int}
     */
    public function ringkasan(?string $dari = null, ?string $sampai = null): array;

    /**
     * Catat transaksi baru.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): FinanceTransaction;

    /**
     * Perbarui transaksi posted.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(FinanceTransaction $transaction, array $data): FinanceTransaction;

    /**
     * Void transaksi (tetap tersimpan, dikeluarkan dari laporan).
     */
    public function void(FinanceTransaction $transaction, string $alasan): FinanceTransaction;
}
