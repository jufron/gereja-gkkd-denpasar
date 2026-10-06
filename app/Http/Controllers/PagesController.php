<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PagesController extends Controller
{
    public function index()
    {
        // TODO: ganti dengan nomor WhatsApp gereja (format internasional tanpa "+").
        $whatsappNumber = '6281234567890';
        $whatsappMessage = rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.');
        $whatsappConfirmMessage = rawurlencode('Shalom, saya ingin mengonfirmasi bukti transfer persembahan / donasi GKKD Denpasar.');

        // Kegiatan & pertemuan jemaat.
        $schedules = [
            [
                'title' => 'Pelayanan',
                'time' => 'Bersamaan dengan Ibadah',
                'day' => 'Minggu',
                'badge' => 'Tim Pelayanan',
                'desc' => 'Ragam tim pelayanan gereja: musik, multimedia, diakonia, doa, anak, dan generasi muda.',
                'link' => route('kegiatan.pelayanan'),
            ],
            [
                'title' => 'Komsel',
                'time' => 'Pukul 19.30 WITA',
                'day' => 'Kamis / Jumat',
                'badge' => 'Komunitas Sel',
                'desc' => 'Kelompok kecil di rumah-rumah jemaat di Renon, Sanur, Denpasar Barat, dan Badung untuk saling peduli.',
                'link' => route('kegiatan.komsel'),
            ],
            [
                'title' => 'Retret / Camp',
                'time' => 'Tahunan',
                'day' => 'Sep / Des',
                'badge' => 'Keluarga & Pemuda',
                'desc' => 'Retret keluarga, camp pemuda, dan camp anak tahunan untuk pembaharuan iman dan relasi.',
                'link' => route('kegiatan.retret-camp'),
            ],
        ];

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

        // Ringkasan berita terkini.
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

        // Banner dinamis untuk hero slider.
        $heroBanners = [
            [
                'image' => asset('images/church-sanctuary.jpg'),
                'alt' => 'Ruang Ibadah GKKD Denpasar',
                'badge' => 'Sanctuary GKKD Denpasar',
                'caption' => 'Suasana ibadah hangat, intim, dan bersahabat',
            ],
            [
                'image' => asset('images/fellowship.jpg'),
                'alt' => 'Komunitas & Persekutuan Jemaat GKKD Denpasar',
                'badge' => 'Komunitas Kasih',
                'caption' => 'Bertumbuh bersama dalam doa dan keakraban keluarga',
            ],
            [
                'image' => asset('images/sunday-school.jpg'),
                'alt' => 'Kelas Anak Sekolah Minggu GKKD Denpasar',
                'badge' => 'Sekolah Minggu Ceria',
                'caption' => 'Pendidikan karakter Alkitab yang interaktif dan ramah anak',
            ],
            [
                'image' => asset('images/outreach.jpg'),
                'alt' => 'Aksi Kasih Pelayanan Masyarakat Bali',
                'badge' => 'Aksi Kasih di Bali',
                'caption' => 'Melayani sesama dengan kepedulian yang tulus',
            ],
        ];

        // Khotbah utama yang disorot di halaman home.
        $featuredSermon = [
            'label' => 'Utama minggu ini',
            'category' => 'Ibadah Raya Minggu Pagi',
            'date' => 'Minggu, 21 September 2025 • 09.00 WITA',
            'title' => 'Hidup dalam Kasih Karunia yang Cukup',
            'preacher' => 'Pdt. Samuel Wijaya',
            'verse' => '2 Korintus 12:7–10',
            'excerpt' => 'Paulus mengajarkan bahwa kelemahan bukan penghalang, melainkan ruang di mana kuasa Kristus dinyatakan dengan nyata. Kasih karunia Tuhan selalu cukup untuk menanggung setiap beban kehidupan kita sehari-hari.',
            'image' => 'https://picsum.photos/seed/pastor-samuel/600/600',
            'image_alt' => 'Foto Pdt. Samuel Wijaya',
            'detail_slug' => 'hidup-dalam-kasih-karunia-yang-cukup',
        ];
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

        return view('home', compact(
            'whatsappNumber',
            'whatsappMessage',
            'whatsappConfirmMessage',
            'schedules',
            'announcements',
            'latestNews',
            'heroBanners',
            'featuredSermon',
            'calendarMonth',
            'calendarInitialDate',
            'calendarEvents',
            'monthlyEvents',
            'donation',
            'focusRing',
        ));
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function berita(Request $request)
    {
        $articles = collect([
            [
                'title' => 'Menghadirkan Damai Kristus di Tengah Dinamika Kota Denpasar',
                'category' => 'Renungan',
                'date' => '20 September 2026',
                'excerpt' => 'Ringkasan seri khotbah bulan ini mengenai panggilan orang percaya untuk hidup sebagai garam dan terang: menjaga integritas di tempat kerja, memelihara kerukunan antarumat beragama di Bali, dan mengasihi tanpa pamrih.',
                'image' => 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&w=1200&q=80',
                'featured' => true,
                'link_url' => null,
                'link_label' => null,
                'status' => 'Bacaan 4 Menit',
            ],
            [
                'title' => 'Laporan Kasih: Penyaluran Paket Sembako & Alat Tulis',
                'category' => 'Aksi Kasih',
                'date' => '15 September 2026',
                'excerpt' => 'Puji Tuhan, tim Diakonia telah mendistribusikan 120 paket perlengkapan sekolah bagi anak-anak dan kebutuhan pokok keluarga di wilayah Denpasar.',
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
            [
                'title' => 'Penerimaan Murid Baru Kelas Anak Semester Ganjil',
                'category' => 'Sekolah Minggu',
                'date' => '10 September 2026',
                'excerpt' => 'Kami menyambut anak-anak usia 1 hingga 12 tahun untuk belajar firman dengan modul karakter Buah Roh yang seru dan interaktif setiap Minggu.',
                'image' => 'https://images.unsplash.com/photo-1497621122273-f5cfb6065c56?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
            [
                'title' => 'Pembukaan Kelompok Sel Baru Wilayah Kuta & Badung',
                'category' => 'Komunitas Sel',
                'date' => '05 September 2026',
                'excerpt' => 'Menjawab kebutuhan jemaat yang berdomisili di sekitar Sunset Road dan Kuta, kini dibuka pertemuan komunitas sel setiap hari Kamis malam.',
                'image' => 'https://images.unsplash.com/photo-1550096141-1b21804f1812?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.komsel'),
                'link_label' => 'Gabung Komsel',
                'status' => null,
            ],
            [
                'title' => 'Tim Multimedia Belajar Tata Siaran Ibadah Baru',
                'category' => 'Pelayanan',
                'date' => '03 September 2026',
                'excerpt' => 'Workshop audio-visual dan pengenalan alur ibadah baru bersama seluruh tim pelayan, menyongsong peningkatan kualitas siaran streaming gereja.',
                'image' => 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
            [
                'title' => 'Membangun Kebiasaan Doa Fajar di Awal Pekan',
                'category' => 'Renungan',
                'date' => '01 September 2026',
                'excerpt' => 'Mencari hadirat Tuhan mengawali hari dengan ucapan syukur dan syafaat — renungan singkat tentang konsistensi doa pribadi di tengah kesibukan.',
                'image' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => null,
                'link_label' => null,
                'status' => 'Renungan 3 Menit',
            ],
            [
                'title' => 'Kelas Pembekalan Baptisan Kudus & Penyerahan Anak',
                'category' => 'Pengumuman',
                'date' => '28 Agustus 2026',
                'excerpt' => 'Bagi jemaat yang rindu menerima baptisan selam atau menyerahkan anak, kelas pembekalan dibuka setiap Minggu setelah ibadah pertama.',
                'image' => 'https://images.unsplash.com/photo-1519491050282-cf00c82424b4?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => null,
                'link_label' => null,
                'status' => 'Pendaftaran Dibuka',
            ],
            [
                'title' => 'Tim Pujian Latihan Lagu Baru untuk Bulan Ini',
                'category' => 'Pelayanan',
                'date' => '24 Agustus 2026',
                'excerpt' => 'Persiapan menu lagu baru bulan depan — para pelayan musik berkumpul menyatukan arransemen dan memimpin jemaat masuk hadirat Tuhan.',
                'image' => 'https://images.unsplash.com/photo-1522158637959-30385a09e0da?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
            [
                'title' => 'Persiapan Camp Anak: Petualangan Firman Musim Panas',
                'category' => 'Sekolah Minggu',
                'date' => '20 Agustus 2026',
                'excerpt' => 'Guru-guru Sekolah Minggu menyiapkan kurikulum camp anak dengan permainan, kerajinan tangan, dan berkemah bersama teman sebaya.',
                'image' => 'https://images.unsplash.com/photo-1566135235200-616a028972c9?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.retret-camp'),
                'link_label' => 'Info Retret/Camp',
                'status' => null,
            ],
            [
                'title' => 'Retret Keluarga: Rumah yang Berakar pada Kristus',
                'category' => 'Komunitas Sel',
                'date' => '14 Agustus 2026',
                'excerpt' => 'Dua hari penuh di Bedugul untuk pasangan dan keluarga: ibadah, seminar keluarga Kristen, dan aktivasi ikatan orang tua–anak.',
                'image' => 'https://images.unsplash.com/photo-1563902341721-029085ad9347?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.retret-camp'),
                'link_label' => 'Info Retret/Camp',
                'status' => null,
            ],
            [
                'title' => 'Bersyukur di Setiap Musim Kehidupan',
                'category' => 'Renungan',
                'date' => '08 Agustus 2026',
                'excerpt' => 'Renungan dari Mazmur tentang bersyukur baik di saat lapang maupun sempit, dan bagaimana ucapan syukur mengubah cara kita memandang hari.',
                'image' => 'https://images.unsplash.com/photo-1478147427282-58a87a120781?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => null,
                'link_label' => null,
                'status' => 'Renungan 4 Menit',
            ],
            [
                'title' => 'Bakti Sosial & Donor Darah Kasih Bersama PMI',
                'category' => 'Pengumuman',
                'date' => '02 Agustus 2026',
                'excerpt' => 'Bekerja sama dengan PMI Kota Denpasar bertempat di aula serbaguna gereja, terbuka bagi jemaat dan masyarakat umum.',
                'image' => 'https://images.unsplash.com/photo-1593113616828-6f22bca04804?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => null,
                'link_label' => null,
                'status' => 'Pendaftaran Dibuka',
            ],
            [
                'title' => 'Kunjungan Kasih ke Jemaat Lanjut Usia',
                'category' => 'Aksi Kasih',
                'date' => '26 Juli 2026',
                'excerpt' => 'Tim Diakonia mengunjungi jemaat lansia yang tinggal sendirian, membawa makanan, senyum, dan doa berkat bagi mereka.',
                'image' => 'https://images.unsplash.com/photo-1557660559-42497f78035b?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
            [
                'title' => 'Pelatihan Guru Sekolah Minggu: Mendengar Seperti Yesus',
                'category' => 'Pelayanan',
                'date' => '18 Juli 2026',
                'excerpt' => 'Penyegaran keterampilan mendongeng dan mendengarkan anak, memperlengkapi guru-guru pelayanan anak menghadapi generasi digital.',
                'image' => 'https://images.unsplash.com/photo-1548625149-fc4a29cf7092?auto=format&fit=crop&w=1200&q=80',
                'featured' => false,
                'link_url' => route('kegiatan.pelayanan'),
                'link_label' => 'Info Tim Pelayanan',
                'status' => null,
            ],
        ])->map(fn (array $a) => (object) $a);

        $categories = $articles->pluck('category')->unique()->values();

        $q = trim((string) $request->query('q', ''));
        $kategori = $request->query('kategori');
        if (! $categories->contains($kategori)) {
            $kategori = null;
        }

        $filtered = $articles
            ->when($kategori, fn ($c) => $c->where('category', $kategori))
            ->when($q !== '', fn ($c) => $c->filter(
                fn ($a) => str_contains(mb_strtolower($a->title.' '.$a->excerpt), mb_strtolower($q))
            ))
            ->values();

        $perPage = 10;
        $page = LengthAwarePaginator::resolveCurrentPage();

        $paginator = (new LengthAwarePaginator(
            $filtered->slice(($page - 1) * $perPage, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => route('berita'), 'query' => $request->query()]
        ))->fragment('warta');

        $featured = (! $kategori && $q === '' && $paginator->onFirstPage())
            ? $filtered->firstWhere('featured', true)
            : null;

        return view('berita', compact('paginator', 'categories', 'featured', 'kategori', 'q'));
    }

    public function galeri()
    {
        return view('galeri');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function kegiatanIndex()
    {
        return view('kegiatan.index');
    }

    public function pelayanan()
    {
        return view('kegiatan.pelayanan');
    }

    public function komsel()
    {
        return view('kegiatan.komsel');
    }

    public function retretCamp()
    {
        return view('kegiatan.retret-camp');
    }

    public function khotbahShow(string $slug)
    {
        return view('kegiatan.khotbah-detail', ['slug' => $slug]);
    }
}
