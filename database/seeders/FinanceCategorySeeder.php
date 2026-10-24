<?php

namespace Database\Seeders;

use App\Models\FinanceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Kategori keuangan awal: pemasukan & pengeluaran.
 *
 * Sack seed ini dijalankan saat database kosong; menambahkan kategori baru
 * tidak akan menimpa yang sudah ada (firstOrCreate).
 */
class FinanceCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            'income' => [
                ['name' => 'Saldo Awal', 'code' => 'IN-01', 'sort_order' => 1],
                ['name' => 'Persembahan Mingguan', 'code' => 'IN-02', 'sort_order' => 2],
                ['name' => 'Perpuluhan', 'code' => 'IN-03', 'sort_order' => 3],
                ['name' => 'Donasi Khusus', 'code' => 'IN-04', 'sort_order' => 4],
                ['name' => 'Sewa Gedung', 'code' => 'IN-05', 'sort_order' => 5],
            ],
            'expense' => [
                ['name' => 'Operasional Gereja', 'code' => 'EX-01', 'sort_order' => 1],
                ['name' => 'Listrik & Air', 'code' => 'EX-02', 'sort_order' => 2],
                ['name' => 'Honor Pelayan', 'code' => 'EX-03', 'sort_order' => 3],
                ['name' => 'Kegiatan & Retreat', 'code' => 'EX-04', 'sort_order' => 4],
                ['name' => 'Diakonia', 'code' => 'EX-05', 'sort_order' => 5],
                ['name' => 'Pemeliharaan Gedung', 'code' => 'EX-06', 'sort_order' => 6],
            ],
        ];

        foreach ($categories as $type => $list) {
            foreach ($list as $category) {
                FinanceCategory::firstOrCreate(
                    ['type' => $type, 'name' => $category['name']],
                    $category + ['type' => $type, 'is_active' => true],
                );
            }
        }
    }
}
