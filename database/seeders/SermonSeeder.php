<?php

namespace Database\Seeders;

use App\Models\Sermon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seed contoh rangkuman khotbah (dari konten lama yang sebelumnya ditulis
 * hardcode di view). Tanpa gambar — front-end jatuh ke avatar inisial.
 */
class SermonSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title' => 'Hidup dalam Kasih Karunia yang Cukup',
                'preacher' => 'Pdt. Samuel Wijaya',
                'preached_at' => '2026-09-21',
                'location' => 'Gedung Utama GKKD Denpasar',
                'content' => '<h3>Poin 1: Mengakui Kelemahan Kita di Hadapan Tuhan</h3><p>Dalam hidup, seringkali kita mencoba menyembunyikan keterbatasan dan kelemahan diri. Namun Paulus mengingatkan bahwa pengakuan akan keterbatasan adalah awal dari masuknya kuasa dan rahmat Tuhan yang memulihkan.</p><h3>Poin 2: Kasih Karunia yang Lebih dari Cukup</h3><p>Tuhan tidak selalu mencabut duri dalam daging atau kesulitan hidup kita, namun Ia memberikan kasih karunia dan ketabahan ekstra sehingga kita mampu melewati setiap pergumulan dengan kemenangan.</p><h3>Poin 3: Kuasa Kristus Sempurna dalam Kelemahan</h3><p>Saat kita sadar tidak mampu mengandalkan kekuatan sendiri, di situlah kita sepenuhnya bergantung kepada Roh Kudus. Sikap penyerahan penuh inilah yang memancarkan kemuliaan Tuhan dalam hidup jemaat.</p>',
            ],
            [
                'title' => 'Mengikut Yesus dengan Sepenuh Hati',
                'preacher' => 'Pdt. Maria Santoso',
                'preached_at' => '2026-09-14',
                'location' => 'Gedung Utama GKKD Denpasar',
                'content' => '<h3>Poin 1: Menyangkal Diri Setiap Hari</h3><p>Menyangkal diri berarti mengutamakan kehendak Tuhan di atas kehendak pribadi dan ego kita.</p><h3>Poin 2: Memikul Salib dengan Sukacita</h3><p>Salib mewakili kesetiaan mengikut Yesus meskipun menghadapi tantangan dan konsekuensi di tengah dunia.</p><h3>Poin 3: Memperoleh Kehidupan Sejati</h3><p>Barangsiapa kehilangan nyawanya karena Kristus, ia akan memperoleh kehidupan kekal yang penuh kelimpahan sukacita.</p>',
            ],
            [
                'title' => 'Doa yang Mengubah Keadaan',
                'preacher' => 'Ev. Yohanes Pratama',
                'preached_at' => '2026-09-10',
                'location' => 'Ruang Konseling & Online Zoom',
                'content' => '<h3>Poin 1: Doa yang Lahir dari Iman</h3><p>Kekuatan doa tidak terletak pada panjangnya kata-kata, melainkan pada ketulusan iman kepada Allah yang maha kuasa.</p><h3>Poin 2: Kuasa Doa Syafaat Bersama</h3><p>Ketika jemaat sepakat dalam doa bersama, ada pengurapan dan kekuatan khusus yang dicurahkan atas gereja dan kota.</p><h3>Poin 3: Keterbukaan dan Saling Mendoakan</h3><p>Saling mengaku dosa dan saling mendoakan membawa kesembuhan rohani maupun jasmani bagi komunitas beriman.</p>',
            ],
        ];

        foreach ($data as $row) {
            Sermon::query()->updateOrCreate(
                ['slug' => Str::slug($row['title'])],
                [...$row, 'status' => 'published', 'published_at' => now()],
            );
        }
    }
}
