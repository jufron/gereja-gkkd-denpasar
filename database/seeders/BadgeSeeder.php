<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Badge kategori untuk jadwal pertemuan & ibadah.
     *
     * @var list<array{name: string, slug: string, color: string}>
     */
    private array $badges = [
        [
            'name' => 'Tim Pelayanan',
            'slug' => 'tim-pelayanan',
            'color' => 'bg-accent/10 text-accent dark:text-accent-soft',
        ],
        [
            'name' => 'Komunitas Sel',
            'slug' => 'komunitas-sel',
            'color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
        ],
        [
            'name' => 'Keluarga & Pemuda',
            'slug' => 'keluarga-pemuda',
            'color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->badges as $badge) {
            Badge::query()->updateOrCreate(
                ['slug' => $badge['slug']],
                ['name' => $badge['name'], 'color' => $badge['color']],
            );
        }
    }
}
