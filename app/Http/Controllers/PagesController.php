<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HomeContentServiceInterface;
use App\Contracts\Services\NewsServiceInterface;
use App\Models\News;
use App\Models\Sermon;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct(
        private readonly HomeContentServiceInterface $homeContentService,
        private readonly NewsServiceInterface $newsService,
    ) {}

    public function index()
    {
        return view('home', $this->homeContentService->getHomeData());
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function berita(Request $request)
    {
        $kategori = $request->query('kategori');

        return view('berita', $this->newsService->getBeritaData(
            kategori: is_string($kategori) ? $kategori : null,
            search: trim((string) $request->query('q', '')),
            queryParams: $request->query(),
        ));
    }

    public function beritaShow(News $news)
    {
        $data = $this->newsService->getBeritaDetail($news->slug);

        return view('berita-detail', $data);
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
        $sermons = Sermon::published()
            ->with('mediaUsages.media')
            ->latest('preached_at')
            ->paginate(9);

        return view('kegiatan.index', compact('sermons'));
    }

    public function pelayanan()
    {
        return view('kegiatan.pelayanan');
    }

    public function pelayananShow(string $slug)
    {
        $teams = [
            'musik' => [
                'name' => 'Pelayanan Musik & Pujian',
                'badge' => 'Tim Musisi',
                'headline' => 'Memimpin masuk ke hadirat Tuhan',
                'intro' => 'Musik bukan sekadar pengiring. Kami percaya pujian membawa jemaat berjumpa dengan Allah. Dari ibadah raya sampai persekutuan kecil, tim musik menyiapkan nada dan hati agar penyembahan terasa hangat dan tulus.',
                'image' => asset('images/church-sanctuary.jpg'),
                'alt' => 'Ruang ibadah GKKD Denpasar',
                'learn' => [
                    'Memimpin pujian dan penyembahan pada ibadah raya dan kebaktian keluarga',
                    'Menyiapkan aransemen lagu sesuai alur ibadah',
                    'Menjaga kualitas vokal dan instrumental dalam setiap pelayanan',
                    'Membangun suasana penyembahan yang khusyuk dan penuh sukacita',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Koordinator membagi jadwal petugas per ibadah',
                    'Vokalis dan pemain instrumen berlatih bersama tiap minggu',
                    'Menjaga komunikasi dengan penanggung jawab ibadah',
                    'Melaporkan kebutuhan alat dan aransemen',
                ],
                'schedule' => [
                    'Latihan rutin: Kamis, 19.00–21.00 WITA di ruang ibadah',
                    'Pemanasan vokal: 30 menit sebelum ibadah',
                    'Evaluasi bulanan bersama tim',
                ],
                'requirements' => [
                    'Bisa menyanyi atau memainkan minimal satu instrumen',
                    'Bersedia hadir latihan rutin',
                    'Senang bekerja dalam tim dan terbuka pada arahan',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Tim Musik GKKD Denpasar.',
            ],
            'multimedia' => [
                'name' => 'Multimedia & Tata Ibadah',
                'badge' => 'Tim Multimedia',
                'headline' => 'Di balik layar ibadah',
                'intro' => 'Setiap lirik yang muncul, suara yang jernih, dan siaran yang lancar ada berkat tangan tim multimedia. Kami bekerja diam-diam di balik layar agar jemaat bisa fokus menyembah tanpa gangguan.',
                'image' => 'https://images.unsplash.com/photo-1748698535024-e246f0da88dc?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                'alt' => 'Operator mengoperasikan panel kontrol suara',
                'learn' => [
                    'Mengoperasikan tata suara, cahaya, dan layar lirik',
                    'Menyiarkan ibadah secara langsung (streaming)',
                    'Mendokumentasikan foto dan video kegiatan gereja',
                    'Mengelola media sosial gereja',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Menyiapkan perangkat audio visual sebelum ibadah',
                    'Mengatur rotasi petugas per minggu',
                    'Menjaga kebersihan dan perawatan alat',
                    'Mendokumentasikan kegiatan gereja',
                ],
                'schedule' => [
                    'Persiapan: Sabtu menjelang ibadah Minggu',
                    'Rotasi petugas per minggu',
                    'Rapat teknis bulanan',
                ],
                'requirements' => [
                    'Minat pada teknis audio, video, atau proyektor',
                    'Tidak perlu ahli, dibimbing mulai nol',
                    'Telaten dan siap bekerja di balik layar',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Tim Multimedia GKKD Denpasar.',
            ],
            'diakonia' => [
                'name' => 'Diakonia & Aksi Kasih',
                'badge' => 'Tim Diakonia',
                'headline' => 'Kasih yang bergerak nyata',
                'intro' => 'Iman tidak berhenti di dalam gedung gereja. Lewat kunjungan jemaat, bakti sosial, donor darah, dan bantuan bagi yang membutuhkan, kami membawa kasih Kristus keluar ke jalan-jalan Denpasar.',
                'image' => asset('images/outreach.jpg'),
                'alt' => 'Kegiatan bakti sosial dan donor darah GKKD Denpasar',
                'learn' => [
                    'Melakukan kunjungan bagi jemaat sakit dan berduka',
                    'Menyelenggarakan bakti sosial dan donor darah',
                    'Menyalurkan bantuan bagi masyarakat sekitar',
                    'Mengelola dana kasih secara transparan',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Mendata jemaat yang membutuhkan perhatian',
                    'Mengorganisir kunjungan dan kegiatan kasih',
                    'Mengelola distribusi bantuan tepat sasaran',
                    'Bekerja sama dengan tim lain untuk aksi sosial',
                ],
                'schedule' => [
                    'Kegiatan kasih terjadwal tiap bulan',
                    'Kunjungan berkala ke jemaat',
                    'Evaluasi program triwulan',
                ],
                'requirements' => [
                    'Hati untuk melayani sesama',
                    'Mau turun langsung ke lapangan',
                    'Rindu memberi waktu dan tenaga',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Tim Diakonia GKKD Denpasar.',
            ],
            'doa' => [
                'name' => 'Tim Doa & Konseling',
                'badge' => 'Tim Doa',
                'headline' => 'Mendampingi dalam doa dan duka',
                'intro' => 'Ada saat hidup terasa berat dan butuh didengar. Tim doa dan konseling mendampingi jemaat lewat syafaat dan pembimbingan pastoral yang rahasia, penuh empati, dan berakar pada firman.',
                'image' => 'https://images.unsplash.com/photo-1611067138996-f3f8906ef13e?ixlib=rb-4.0.3&w=1200&q=80&auto=format&fit=crop',
                'alt' => 'Lilin menyala di dalam gereja',
                'learn' => [
                    'Melayani doa syafaat setelah ibadah',
                    'Memberikan konseling pastoral yang rahasia',
                    'Mendampingi keluarga dalam masa sulit',
                    'Mengembangkan jaringan doa mingguan',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Menyediakan pelayanan doa seusai ibadah',
                    'Menjaga kerahasiaan semua pendampingan',
                    'Mengatur jadwal jaga doa',
                    'Mengikuti pembinaan dan pelatihan konseling',
                ],
                'schedule' => [
                    'Pelayanan doa: seusai ibadah raya',
                    'Jaringan doa mingguan',
                    'Pembinaan konseling berkala',
                ],
                'requirements' => [
                    'Mampu menjaga kerahasiaan',
                    'Penuh empati dan sabar mendengar',
                    'Dewasa rohani dan bersedia dibina',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Tim Doa & Konseling GKKD Denpasar.',
            ],
            'anak' => [
                'name' => 'Pelayanan Anak',
                'badge' => 'Tim Guru Anak',
                'headline' => 'Menabur iman sejak kecil',
                'intro' => 'Anak-anak belajar mengenal Yesus lewat cerita, permainan, dan senyum para guru. Usia 3–12 tahun adalah masa emas; kami membantu mereka bertumbuh dengan sukacita.',
                'image' => asset('images/sunday-school.jpg'),
                'alt' => 'Kegiatan Sekolah Minggu GKKD Denpasar',
                'learn' => [
                    'Mengajar Sekolah Minggu usia 3–12 tahun',
                    'Menyiapkan cerita Alkitab dan aktivitas kreatif',
                    'Mendampingi permainan dan persekutuan anak',
                    'Mengadakan perayaan khusus anak seperti natal',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Menyiapkan materi dan alat peraga pengajaran',
                    'Membagi peran guru per kelas usia',
                    'Menjaga keamanan dan kenyamanan anak',
                    'Berkomunikasi dengan orang tua',
                ],
                'schedule' => [
                    'Sekolah Minggu: Minggu, 09.00 WITA',
                    'Persiapan materi: Sabtu',
                    'Rapat guru bulanan',
                ],
                'requirements' => [
                    'Sayang pada anak-anak',
                    'Sabar dan kreatif',
                    'Bersedia bekerja sama dengan guru lain',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Sekolah Minggu GKKD Denpasar.',
            ],
            'pemuda' => [
                'name' => 'Pelayanan Generasi Muda',
                'badge' => 'Tim Pemuda',
                'headline' => 'Generasi muda, agen perubahan',
                'intro' => 'Pemuda dan mahasiswa memiliki energi yang bisa mengubah zaman. Lewat pendalaman firman dan persekutuan, kami memperlengkapi mereka menjadi saksi Kristus di kampus, tempat kerja, dan keluarga.',
                'image' => asset('images/fellowship.jpg'),
                'alt' => 'Persekutuan pemuda dan mahasiswa GKKD Denpasar',
                'learn' => [
                    'Mengikuti pendalaman firman bersama',
                    'Terlibat dalam persekutuan pemuda dan mahasiswa',
                    'Mengembangkan kepemimpinan Kristen',
                    'Mengadakan misi dan aksi sosial di kampus',
                ],
                'lead' => 'Pnt. [Nama Ketua Tim]',
                'members' => [
                    'Sdr./Sdri. [Nama Anggota 1]',
                    'Sdr./Sdri. [Nama Anggota 2]',
                    'Sdr./Sdri. [Nama Anggota 3]',
                ],
                'duties' => [
                    'Menyelenggarakan pertemuan pemuda rutin',
                    'Merancang program pendalaman firman',
                    'Menjalin relasi dengan mahasiswa Kristen',
                    'Mengorganisir aksi sosial di kampus',
                ],
                'schedule' => [
                    'Persekutuan pemuda: Jumat, 19.00 WITA',
                    'Pendalaman firman berkala',
                    'Retret dan pembinaan tahunan',
                ],
                'requirements' => [
                    'Berusia muda atau mahasiswa',
                    'Antusias mempelajari firman',
                    'Rindu menjadi saksi Kristus',
                ],
                'wa' => 'Shalom, saya tertarik melayani di Tim Pemuda GKKD Denpasar.',
            ],
        ];

        if (! isset($teams[$slug])) {
            abort(404);
        }

        return view('kegiatan.pelayanan-detail', ['tim' => $teams[$slug]]);
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
        $sermon = Sermon::published()
            ->with('mediaUsages.media')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('kegiatan.khotbah-detail', compact('sermon'));
    }
}
