<?php

namespace Database\Seeders;

use App\Models\FinanceCategory;
use App\Models\FinanceTransaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Contoh transaksi keuangan (kas masuk / kas keluar) untuk 9 bulan terakhir.
 *
 * Idempotent: hanya berjalan jika belum ada transaksi sama sekali, sehingga
 * data user yang sudah tercatat tidak pernah ditimpa. Untuk melihat data
 * contoh, jalankan `php artisan migrate:fresh --seed`.
 */
class FinanceTransactionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (FinanceTransaction::exists()) {
            return;
        }

        $admin = User::where('email', 'admin@gkkd-denpasar.id')->first()
            ?? User::firstOrFail();

        $cat = fn (string $type, string $name): FinanceCategory => FinanceCategory::query()
            ->where('type', $type)
            ->where('name', $name)
            ->firstOrFail();

        $income = [
            'saldo' => $cat('income', 'Saldo Awal'),
            'persembahan' => $cat('income', 'Persembahan Mingguan'),
            'perpuluhan' => $cat('income', 'Perpuluhan'),
            'donasi' => $cat('income', 'Donasi Khusus'),
            'sewa' => $cat('income', 'Sewa Gedung'),
        ];
        $expense = [
            'operasional' => $cat('expense', 'Operasional Gereja'),
            'listrik' => $cat('expense', 'Listrik & Air'),
            'honor' => $cat('expense', 'Honor Pelayan'),
            'kegiatan' => $cat('expense', 'Kegiatan & Retreat'),
            'diakonia' => $cat('expense', 'Diakonia'),
            'pemeliharaan' => $cat('expense', 'Pemeliharaan Gedung'),
        ];

        $today = now()->startOfDay();
        $start = now()->startOfMonth()->subMonths(8)->startOfMonth();

        $noMasuk = 0;
        $noKeluar = 0;
        $isFirstMonth = true;

        for ($month = $start->copy(); $month->lessThanOrEqualTo($today); $month->addMonth()) {
            $yearMonth = $month->format('Ym');
            $daysInMonth = $month->daysInMonth;

            /** Tambah transaksi hanya jika tanggalnya ≤ hari ini (hindari masa depan). */
            $add = function (FinanceCategory $category, int $amount, string $description, int $day, string $prefix, string &$no) use ($month, $daysInMonth, $today, $admin, $yearMonth) {
                if ($day > $daysInMonth || $month->copy()->day($day)->greaterThan($today)) {
                    return;
                }

                $no++;
                $reference = $prefix.'-'.$yearMonth.'-'.str_pad((string) $no, 3, '0', STR_PAD_LEFT);

                FinanceTransaction::create([
                    'finance_category_id' => $category->id,
                    'transaction_date' => $month->copy()->day($day),
                    'amount' => $amount,
                    'description' => $description,
                    'reference_no' => $reference,
                    'status' => 'posted',
                    'created_by' => $admin->id,
                ]);
            };

            // ── Pemasukan ────────────────────────────────────────────────
            if ($isFirstMonth) {
                $add($income['saldo'], 15_000_000, 'Saldo awal pencatatan keuangan', 1, 'KM', $noMasuk);
            }

            for ($week = 0; $week < 4; $week++) {
                $d = 5 + $week * 7; // Minggu: tanggal 5, 12, 19, 26
                $variasi = [0, 120_000, 85_000, 260_000][$week] ?? 0;
                $add($income['persembahan'], 975_000 + $variasi, 'Persembahan Ibadah Mingguan', $d, 'KM', $noMasuk);
            }

            $add($income['perpuluhan'], 2_000_000 + ($month->day % 3) * 150_000, 'Perpuluhan jemaat', 28, 'KM', $noMasuk);

            if ($month->month % 2 === 0) {
                $add($income['donasi'], 750_000, 'Donasi khusus bantuan jemaat', 18, 'KM', $noMasuk);
            }

            if ($month->month % 3 === 0) {
                $add($income['sewa'], 1_500_000, 'Sewa gedung kegiatan eksternal', 22, 'KM', $noMasuk);
            }

            // ── Pengeluaran ──────────────────────────────────────────────
            $add($expense['operasional'], 900_000, 'Operasional gereja mingguan', 7, 'KK', $noKeluar);
            $add($expense['listrik'], 725_000 + $month->day * 7_000, 'Tagihan listrik & air', 10, 'KK', $noKeluar);
            $add($expense['honor'], 3_500_000, 'Honor pelayan & pengkhotbah', 25, 'KK', $noKeluar);

            if ($month->month % 2 === 1) {
                $add($expense['kegiatan'], 1_200_000, 'Kegiatan & retreat pemuda', 20, 'KK', $noKeluar);
            }

            if ($month->month % 3 === 0) {
                $add($expense['diakonia'], 500_000, 'Diakonia jemaat tidak mampu', 15, 'KK', $noKeluar);
            }

            if ($month->month % 4 === 0) {
                $add($expense['pemeliharaan'], 1_750_000, 'Pemeliharaan gedung gereja', 27, 'KK', $noKeluar);
            }

            $isFirstMonth = false;
        }

        // Satu contoh transaksi void (bulan lalu) untuk mendemokan fitur.
        $voidMonth = now()->startOfMonth()->subMonth();
        if ($voidMonth->lessThanOrEqualTo($today)) {
            $voidDay = min(15, $voidMonth->daysInMonth);
            if (! $voidMonth->copy()->day($voidDay)->greaterThan($today)) {
                FinanceTransaction::create([
                    'finance_category_id' => $expense['operasional']->id,
                    'transaction_date' => $voidMonth->copy()->day($voidDay),
                    'amount' => 450_000,
                    'description' => 'Contoh: operasional salah input nominal',
                    'reference_no' => 'KK-'.$voidMonth->format('Ym').'-000',
                    'status' => 'void',
                    'voided_at' => now(),
                    'void_reason' => 'Contoh: salah input nominal, dicatat ulang.',
                    'created_by' => $admin->id,
                ]);
            }
        }
    }
}
