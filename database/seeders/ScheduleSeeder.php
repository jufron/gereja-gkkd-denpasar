<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Jadwal pertemuan & ibadah jemaat GKKD Denpasar.
     *
     * @var list<array{badge: string, title: string, time: string, day: string, description: string, sort_order: int}>
     */
    private array $schedules = [
        [
            'badge' => 'tim-pelayanan',
            'title' => 'Pelayanan',
            'time' => 'Bersamaan dengan Ibadah',
            'day' => 'Minggu',
            'description' => 'Ragam tim pelayanan gereja: musik, multimedia, diakonia, doa, anak, dan generasi muda.',
            'sort_order' => 1,
        ],
        [
            'badge' => 'komunitas-sel',
            'title' => 'Komsel',
            'time' => 'Pukul 19.30 WITA',
            'day' => 'Kamis / Jumat',
            'description' => 'Kelompok kecil di rumah-rumah jemaat di Renon, Sanur, Denpasar Barat, dan Badung untuk saling peduli.',
            'sort_order' => 2,
        ],
        [
            'badge' => 'keluarga-pemuda',
            'title' => 'Retret / Camp',
            'time' => 'Tahunan',
            'day' => 'Sep / Des',
            'description' => 'Retret keluarga, camp pemuda, dan camp anak tahunan untuk pembaharuan iman dan relasi.',
            'sort_order' => 3,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = Badge::query()->pluck('id', 'slug');

        foreach ($this->schedules as $schedule) {
            Schedule::query()->updateOrCreate(
                ['title' => $schedule['title']],
                [
                    'badge_id' => $badges[$schedule['badge']],
                    'time' => $schedule['time'],
                    'day' => $schedule['day'],
                    'description' => $schedule['description'],
                    'sort_order' => $schedule['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}
