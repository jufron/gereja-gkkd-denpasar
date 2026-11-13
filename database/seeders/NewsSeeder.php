<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    private array $articles = [
        [
            'slug' => 'menghadirkan-damai-kristus-di-denpasar',
            'category' => 'renungan',
            'title' => 'Menghadirkan Damai Kristus di Tengah Dinamika Kota Denpasar',
            'excerpt' => 'Refleksi mendalam mengenai panggilan jemaat untuk hidup sebagai pembawa damai dan teladan di tempat kerja.',
            'published_at' => '2026-09-20 08:00:00',
            'content' => '
                <p>Setiap kota memiliki denyut nadinya sendiri, dan Denpasar tidak terkecuali. Di tengah kesibukan lalu lintas, pasar, dan hiruk-pikuk pariwisata, Tuhan memanggil kita untuk menjadi saksi damai sejahtera-Nya.</p>
                <p>Paulus menasihatkan jemaat di Filipi untuk "memikirkan perkara yang di atas" namun tetap hadir sepenuhnya dalam realitas kehidupan sehari-hari.</p>
                <blockquote>"Janganlah hendaknya kamu kuatir tentang apa pun juga, tetapi nyatakanlah dalam segala hal keinginanmu kepada Allah dalam doa dan permohonan dengan ucapan syukur." — Filipi 4:6</blockquote>
                <p>Damai sejahtera bukan berarti tanpa pergumulan, melainkan kepastian bahwa Kristus menyertai dalam setiap langkah. Di tempat kerja, di keluarga, dan di tengah masyarakat, kita dipanggil menjadi teladan yang memancarkan kasih-Nya.</p>
                <h2>Praktik Hidup Pembawa Damai</h2>
                <ul>
                    <li>Mulai setiap hari dengan doa dan ucapan syukur.</li>
                    <li>Menjaga integritas dalam pekerjaan dan perkataan.</li>
                    <li>Menjadi pendengar yang baik di tengah perbedaan.</li>
                    <li>Mengasihi tanpa pamrih, sebagaimana Kristus mengasihi kita.</li>
                </ul>
                <p>Mari kita bawa terang kasih Kristus ke setiap sudut kota ini, sehingga Denpasar semakin melihat kemuliaan Allah melalui kehidupan kita.</p>
            ',
        ],
        [
            'slug' => 'laporan-aksi-kasih-sembako-dan-perlengkapan-belajar',
            'category' => 'aksi-kasih',
            'title' => 'Laporan Aksi Kasih: Penyaluran Paket Sembako & Perlengkapan Belajar',
            'excerpt' => 'Sebanyak 120 paket perlengkapan sekolah dan kebutuhan pokok telah disalurkan bagi keluarga prasejahtera di Denpasar.',
            'published_at' => '2026-09-15 08:00:00',
            'content' => '
                <p>Puji Tuhan. melalui tim Diakonia, gereja telah menyalurkan <strong>120 paket perlengkapan sekolah</strong> dan kebutuhan pokok bagi keluarga prasejahtera di wilayah Denpasar.</p>
                <p>Aksi kasih ini adalah wujud nyata iman kita — bahwa kasih Kristus tidak berhenti di dalam gedung gereja, tetapi menjangkau sesama yang membutuhkan.</p>
                <h2>Rincian Penyaluran</h2>
                <ul>
                    <li>60 paket alat tulis dan seragam untuk anak sekolah.</li>
                    <li>40 paket sembako untuk keluarga yang membutuhkan.</li>
                    <li>20 paket khusus lansia yang tinggal sendirian.</li>
                </ul>
                <blockquote>"Dan siapa yang memberi minum hanya secangkir air putih kepada salah seorang yang kecil ini, sesungguhnya Aku berkata kepadamu: ia tidak akan kehilangan upahnya." — Matius 10:42</blockquote>
                <p>Terima kasih atas partisipasi jemaat. Aksi kasih akan terus berlanjut secara berkala.</p>
            ',
        ],
        [
            'slug' => 'keceriaan-anak-sekolah-minggu-kelas-karakter',
            'category' => 'sekolah-minggu',
            'title' => 'Keceriaan Anak-Anak di Kelas Karakter Sekolah Minggu',
            'excerpt' => 'Mengenalkan benih firman Tuhan sejak dini melalui metode mendongeng, kreativitas tangan, dan lagu gerak tari.',
            'published_at' => '2026-09-10 08:00:00',
            'content' => '
                <p>Sabtu lalu, kelas karakter Sekolah Minggu berlangsung penuh keceriaan. Sebanyak 45 anak hadir dan belajar tentang kasih melalui metode yang interaktif.</p>
                <p>Kegiatan dimulai dengan lagu gerak tari, dilanjutkan mendongeng kisah, dan ditutup dengan kreativitas tangan membuat kartu kasih untuk diberikan kepada orang tua.</p>
                <blockquote>"Biarkanlah anak-anak itu datang kepada-Ku, jangan menghalang-halangi mereka, sebab orang-orang yang seperti itulah yang empunya Kerajaan Allah." — Markus 10:14</blockquote>
                <p>Kami percaya benih firman yang ditanam sejak dini akan bertumbuh dan berbuah. Orang tua diundang ikut terlibat dalam pelayanan anak.</p>
            ',
        ],
    ];

    public function run(): void
    {
        $author = User::query()->orderBy('id')->first();

        if (! $author) {
            return;
        }

        foreach ($this->articles as $article) {
            $category = NewsCategory::query()->where('slug', $article['category'])->first();

            News::query()->updateOrCreate(
                ['slug' => $article['slug']],
                [
                    'news_category_id' => $category?->id,
                    'user_id' => $author->id,
                    'title' => $article['title'],
                    'excerpt' => $article['excerpt'],
                    'content' => trim($article['content']),
                    'status' => 'published',
                    'published_at' => $article['published_at'],
                ],
            );
        }
    }
}
