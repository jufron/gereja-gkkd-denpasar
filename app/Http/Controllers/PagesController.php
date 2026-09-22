<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PagesController extends Controller
{
    public function index()
    {
        return view('home');
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
