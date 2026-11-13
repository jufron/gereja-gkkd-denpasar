<?php

namespace App\Services;

use App\Contracts\Services\HomeContentServiceInterface;
use App\Models\HeroBanner;
use App\Models\News;
use App\Models\Schedule;
use App\Models\Sermon;
use Illuminate\Support\Str;

class HomeContentService implements HomeContentServiceInterface
{
    /**
     * Susun seluruh data untuk halaman utama (jadwal dari database, sisanya statis).
     *
     * @return array<string, mixed>
     */
    public function getHomeData(): array
    {
        // TODO: ganti dengan nomor WhatsApp gereja (format internasional tanpa "+").
        $whatsappNumber = '6281234567890';
        $whatsappMessage = rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.');
        $whatsappConfirmMessage = rawurlencode('Shalom, saya ingin mengonfirmasi bukti transfer persembahan / donasi GKKD Denpasar.');

        // Kegiatan & pertemuan jemaat (diambil dari tabel schedules + relasi badges).
        $schedules = Schedule::query()
            ->with('badge')
            ->active()
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Schedule $schedule) => [
                'title' => $schedule->title,
                'time' => $schedule->time,
                'day' => $schedule->day,
                'badge' => $schedule->badge?->name,
                'badge_color' => $schedule->badge?->color,
                'desc' => $schedule->description,
            ])
            ->all();

        // Ringkasan pengumuman terbaru gereja.
        $announcements = [
            [
                'date' => '28 Sep 2026',
                'tag' => 'Sakramen',
                'title' => 'Pendaftaran Baptisan Kudus & Penyerahan Anak',
                'summary' => 'Bagi jemaat yang rindu menerima baptisan selam atau menyerahkan anak, kelas pembekalan dibuka mulai Minggu depan.',
                'badge_color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
            ],
            [
                'date' => '26 Sep 2026',
                'tag' => 'Pelayanan',
                'title' => 'Pertemuan Tim Multimedia & Pelayan Musik',
                'summary' => 'Workshop audio-visual dan pengenalan alur ibadah baru bersama seluruh tim pelayan hari Sabtu pukul 16.00 WITA.',
                'badge_color' => 'bg-accent/10 text-accent dark:text-accent-soft',
            ],
            [
                'date' => '04 Okt 2026',
                'tag' => 'Aksi Kasih',
                'title' => 'Bakti Sosial & Donor Darah Kasih',
                'summary' => 'Bekerja sama dengan PMI Kota Denpasar bertempat di aula serbaguna gereja. Terbuka bagi jemaat dan masyarakat umum.',
                'badge_color' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
            ],
            [
                'date' => '11 Okt 2026',
                'tag' => 'Komunitas',
                'title' => 'Retreat Pemuda & Profesional Muda 2026',
                'summary' => 'Pendaftaran awal dibuka untuk retreat tahunan di Bedugul dengan tema "Berakar dan Berbuah di Era Digital".',
                'badge_color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
            ],
        ];

        // Ringkasan berita terkini — ambil dari DB (published terbaru).
        // Jatuh ke contoh statis bila belum ada data berita.
        $latestNewsQuery = News::query()
            ->with(['category', 'mediaUsages.media'])
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($latestNewsQuery->isEmpty()) {
            $latestNews = [
                [
                    'title' => 'Menghadirkan Damai Kristus di Tengah Dinamika Kota Denpasar',
                    'date' => '20 September 2026',
                    'category' => 'Khotbah & Renungan',
                    'image' => asset('images/church-sanctuary.jpg'),
                    'summary' => 'Refleksi mendalam mengenai panggilan jemaat untuk hidup sebagai pembawa damai dan teladan di tempat kerja.',
                    'read_time' => '4 Menit Baca',
                    'link' => route('berita'),
                ],
                [
                    'title' => 'Laporan Aksi Kasih: Penyaluran Paket Sembako & Perlengkapan Belajar',
                    'date' => '15 September 2026',
                    'category' => 'Bakti Sosial',
                    'image' => asset('images/outreach.jpg'),
                    'summary' => 'Sebanyak 120 paket perlengkapan sekolah dan kebutuhan pokok telah disalurkan bagi keluarga prasejahtera di Denpasar.',
                    'read_time' => '3 Menit Baca',
                    'link' => route('berita'),
                ],
                [
                    'title' => 'Keceriaan Anak-Anak di Kelas Karakter Sekolah Minggu',
                    'date' => '10 September 2026',
                    'category' => 'Sekolah Minggu',
                    'image' => asset('images/sunday-school.jpg'),
                    'summary' => 'Mengenalkan benih firman Tuhan sejak dini melalui metode mendongeng, kreativitas tangan, dan lagu gerak tari.',
                    'read_time' => '3 Menit Baca',
                    'link' => route('berita'),
                ],
            ];
        } else {
            $latestNews = $latestNewsQuery->map(fn ($news) => [
                'title' => $news->title,
                'date' => $news->published_at?->translatedFormat('d F Y') ?? '',
                'category' => $news->category?->name ?? 'Berita',
                'category_color' => $news->category?->color,
                'image' => $news->banner_url ?: asset('images/church-sanctuary.jpg'),
                'summary' => $news->excerpt ?: Str::limit(strip_tags($news->content), 140),
                'read_time' => max(1, (int) ceil(str_word_count(strip_tags($news->content)) / 200)).' Menit Baca',
                'link' => route('berita.show', $news->slug),
            ])->all();
        }

        // Banner dinamis untuk hero slider (dari database).
        $heroBanners = HeroBanner::query()
            ->with('media')
            ->active()
            ->ordered()
            ->get()
            ->map(fn (HeroBanner $banner) => [
                'image' => $banner->media?->getUrl(),
                'alt' => $banner->alt,
                'badge' => $banner->badge,
                'caption' => $banner->caption,
            ])
            ->all();

        // jatuh tempo: cegah slider dengan total 0 (modulus nol di Alpine).
        if ($heroBanners === []) {
            $heroBanners = [[
                'image' => asset('images/church-sanctuary.jpg'),
                'alt' => 'Ruang Ibadah GKKD Denpasar',
                'badge' => 'Sanctuary GKKD Denpasar',
                'caption' => 'Suasana ibadah hangat, intim, dan bersahabat',
            ]];
        }

        // Khotbah utama yang disorot di halaman home — ambil dari DB
        // (published terbaru). Jatuh ke contoh statis bila belum ada data.
        $featuredSermon = [
            'label' => 'Utama minggu ini',
            'category' => 'Rangkuman Khotbah',
            'date' => 'Minggu, 21 September 2025 • 09.00 WITA',
            'title' => 'Hidup dalam Kasih Karunia yang Cukup',
            'preacher' => 'Pdt. Samuel Wijaya',
            'excerpt' => 'Paulus mengajarkan bahwa kelemahan bukan penghalang, melainkan ruang di mana kuasa Kristus dinyatakan dengan nyata. Kasih karunia Tuhan selalu cukup untuk menanggung setiap beban kehidupan kita sehari-hari.',
            'image' => asset('images/church-sanctuary.jpg'),
            'image_alt' => 'Rangkuman khotbah GKKD Denpasar',
            'detail_slug' => 'hidup-dalam-kasih-karunia-yang-cukup',
        ];

        $sermon = Sermon::published()->with('mediaUsages.media')->latest('preached_at')->first();

        if ($sermon) {
            $featuredSermon = [
                'label' => 'Utama minggu ini',
                'category' => 'Rangkuman Khotbah',
                'date' => $sermon->preached_at->translatedFormat('l, d F Y'),
                'title' => $sermon->title,
                'preacher' => $sermon->preacher,
                'excerpt' => $sermon->summary,
                'image' => $sermon->thumbnail_url ?: asset('images/church-sanctuary.jpg'),
                'image_alt' => $sermon->title,
                'detail_slug' => $sermon->slug,
            ];
        }

        $featuredSermon['detail_url'] = route('kegiatan.khotbah.show', $featuredSermon['detail_slug']);

        // Kalender event & daftar agenda bulan berjalan.
        $calendarMonth = 'Oktober 2026';
        $calendarInitialDate = '2026-10-01';
        $calendarEvents = [
            ['id' => '1', 'title' => 'Bakti Sosial & Donor Darah', 'start' => '2026-10-04', 'color' => '#e11d48'],
            ['id' => '2', 'title' => 'Retreat Pemuda Bedugul', 'start' => '2026-10-11', 'end' => '2026-10-14', 'color' => '#2563eb'],
            ['id' => '3', 'title' => 'Lokakarya Musik & Multimedia', 'start' => '2026-10-18', 'color' => '#8a00c2'],
            ['id' => '4', 'title' => 'Baptisan Kudus & Penyerahan Anak', 'start' => '2026-10-25', 'color' => '#059669'],
        ];
        $monthlyEvents = [
            [
                'month' => 'OKT',
                'day' => '04',
                'tag' => 'Aksi Kasih',
                'tag_color' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
                'date_color' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
                'title' => 'Bakti Sosial & Donor Darah Kasih',
                'meta' => 'Sabtu • 09.00 WITA • Aula Serbaguna',
                'desc' => 'Bakti sosial donor darah bersama PMI dan penyaluran sembako.',
            ],
            [
                'month' => 'OKT',
                'day' => '11',
                'tag' => 'Pemuda & Mahasiswa',
                'tag_color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
                'date_color' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
                'title' => 'Retreat Pemuda & Profesional Muda 2026',
                'meta' => 'Minggu – Selasa • Villa Bedugul, Bali',
                'desc' => 'Retreat bertema Berakar dan Berbuah di Era Digital.',
            ],
            [
                'month' => 'OKT',
                'day' => '18',
                'tag' => 'Pelayanan',
                'tag_color' => 'bg-accent/10 text-accent dark:text-accent-soft',
                'date_color' => 'bg-accent/10 text-accent dark:text-accent-soft',
                'title' => 'Lokakarya Musik & Multimedia Gereja',
                'meta' => 'Minggu • 14.00 WITA • Ruang Utama',
                'desc' => 'Pembekalan sound system, live streaming, & worship team.',
            ],
            [
                'month' => 'OKT',
                'day' => '25',
                'tag' => 'Sakramen',
                'tag_color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
                'date_color' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
                'title' => 'Baptisan Kudus & Penyerahan Anak',
                'meta' => 'Minggu • 09.00 WITA • Sanctuary Utama',
                'desc' => 'Pelayanan sakramen baptisan kudus jemaat.',
            ],
        ];

        // Informasi persembahan & donasi.
        $donation = [
            'bank_name' => 'BCA (Bank Central Asia)',
            'bank_branch' => 'KCP Denpasar',
            'account_number' => '146-888-9900',
            'account_number_raw' => '1468889900',
            'account_name' => 'Gereja Kristen Kemuliaan Allah (GKKD Denpasar)',
            'qris_nmid' => 'ID1020268889901',
            'qris_merchant' => 'GKKD DENPASAR',
            'verse' => '"Hendaklah masing-masing memberikan menurut kerelaan hatinya, jangan dengan sedih hati atau karena paksaan." (2 Korintus 9:7)',
        ];

        $focusRing = 'focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface';

        return [
            'whatsappNumber' => $whatsappNumber,
            'whatsappMessage' => $whatsappMessage,
            'whatsappConfirmMessage' => $whatsappConfirmMessage,
            'schedules' => $schedules,
            'announcements' => $announcements,
            'latestNews' => $latestNews,
            'heroBanners' => $heroBanners,
            'featuredSermon' => $featuredSermon,
            'calendarMonth' => $calendarMonth,
            'calendarInitialDate' => $calendarInitialDate,
            'calendarEvents' => $calendarEvents,
            'monthlyEvents' => $monthlyEvents,
            'donation' => $donation,
            'focusRing' => $focusRing,
        ];
    }
}
