<?php

namespace Database\Seeders;

use App\Models\AssetLibrary;
use App\Models\HeroBanner;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    private const BANNERS = [
        [
            'file' => 'church-sanctuary.jpg',
            'badge' => 'Sanctuary GKKD Denpasar',
            'alt' => 'Ruang Ibadah GKKD Denpasar',
            'caption' => 'Suasana ibadah hangat, intim, dan bersahabat',
        ],
        [
            'file' => 'fellowship.jpg',
            'badge' => 'Komunitas Kasih',
            'alt' => 'Komunitas & Persekutuan Jemaat GKKD Denpasar',
            'caption' => 'Bertumbuh bersama dalam doa dan keakraban keluarga',
        ],
        [
            'file' => 'sunday-school.jpg',
            'badge' => 'Sekolah Minggu Ceria',
            'alt' => 'Kelas Anak Sekolah Minggu GKKD Denpasar',
            'caption' => 'Pendidikan karakter Alkitab yang interaktif dan ramah anak',
        ],
        [
            'file' => 'outreach.jpg',
            'badge' => 'Aksi Kasih di Bali',
            'alt' => 'Aksi Kasih Pelayanan Masyarakat Bali',
            'caption' => 'Melayani sesama dengan kepedulian yang tulus',
        ],
    ];

    public function run(): void
    {
        if (HeroBanner::query()->exists()) {
            return;
        }

        $library = AssetLibrary::singleton();

        foreach (self::BANNERS as $index => $banner) {
            $path = public_path('images/'.$banner['file']);

            if (! is_file($path)) {
                continue;
            }

            $media = $library
                ->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('hero-banner');

            HeroBanner::create([
                'media_id' => $media->id,
                'badge' => $banner['badge'],
                'caption' => $banner['caption'],
                'alt' => $banner['alt'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
