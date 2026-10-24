<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Kategori berita awal — sama dengan label yang dipakai artikel berita
     * di halaman publik, agar dashboard dan halaman berita tetap konsisten.
     *
     * @var list<array{name: string, slug: string, color: string, description: string, sort_order: int}>
     */
    private array $categories = [
        [
            'name' => 'Renungan',
            'slug' => 'renungan',
            'color' => 'bg-accent/10 text-accent dark:text-accent-soft',
            'description' => 'Renungan firman dan khotbah peneguh iman jemaat.',
            'sort_order' => 1,
        ],
        [
            'name' => 'Aksi Kasih',
            'slug' => 'aksi-kasih',
            'color' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
            'description' => 'Kegiatan diakonia dan kepedulian sosial gereja.',
            'sort_order' => 2,
        ],
        [
            'name' => 'Sekolah Minggu',
            'slug' => 'sekolah-minggu',
            'color' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400',
            'description' => 'Kabar pelayanan anak dan kelas karakter Sekolah Minggu.',
            'sort_order' => 3,
        ],
        [
            'name' => 'Komunitas Sel',
            'slug' => 'komunitas-sel',
            'color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
            'description' => 'Kabar pertumbuhan komsel dan persekutuan jemaat.',
            'sort_order' => 4,
        ],
        [
            'name' => 'Pelayanan',
            'slug' => 'pelayanan',
            'color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
            'description' => 'Informasi seputar tim pelayanan dan pelatihan pelayan.',
            'sort_order' => 5,
        ],
        [
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
            'color' => 'bg-slate-500/10 text-slate-600 dark:text-slate-400',
            'description' => 'Pemberitahuan resmi dan agenda penting jemaat.',
            'sort_order' => 6,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            NewsCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'color' => $category['color'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}
