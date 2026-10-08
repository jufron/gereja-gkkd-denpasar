<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Pengaturan default aplikasi (umum, kontak, donasi, media sosial, SEO).
     *
     * @var list<array{group: string, key: string, value: mixed, type: string, description: string, is_public: bool}>
     */
    private array $settings = [
        // Umum.
        ['general', 'site_name', 'GKKD Denpasar', 'string', 'Nama situs/aplikasi', true],
        ['general', 'site_tagline', 'Gereja Kristen Kemuliaan Allah', 'string', 'Tagline situs', true],
        ['general', 'site_description', 'Situs resmi GKKD Denpasar — berita, kegiatan, pelayanan, dan informasi jemaat.', 'text', 'Deskripsi singkat situs', true],
        ['general', 'timezone', 'Asia/Makassar', 'string', 'Zona waktu aplikasi', false],
        ['general', 'locale', 'id', 'string', 'Bahasa default aplikasi', false],

        // Kontak.
        ['contact', 'whatsapp_number', '6281234567890', 'string', 'Nomor WhatsApp gereja (format internasional tanpa +)', true],
        ['contact', 'whatsapp_message', 'Shalom, saya ingin bertanya tentang GKKD Denpasar.', 'text', 'Pesan default WhatsApp', true],
        ['contact', 'phone', '(0361) 123-4567', 'string', 'Nomor telepon gereja', true],
        ['contact', 'email', 'info@gkkd-denpasar.id', 'string', 'Email resmi gereja', true],
        ['contact', 'address', 'Jl. Raya Puputan, Denpasar, Bali', 'text', 'Alamat gereja', true],
        ['contact', 'maps_url', 'https://maps.google.com/?q=GKKD+Denpasar', 'string', 'Tautan Google Maps', true],

        // Donasi.
        ['donation', 'bank_name', 'BCA (Bank Central Asia)', 'string', 'Nama bank penerima', true],
        ['donation', 'bank_branch', 'KCP Denpasar', 'string', 'Cabang bank', true],
        ['donation', 'account_number', '146-888-9900', 'string', 'Nomor rekening', true],
        ['donation', 'account_number_raw', '1468889900', 'string', 'Nomor rekening tanpa tanda hubung', true],
        ['donation', 'account_name', 'Gereja Kristen Kemuliaan Allah (GKKD Denpasar)', 'string', 'Nama pemilik rekening', true],
        ['donation', 'qris_nmid', 'ID1020268889901', 'string', 'NMID QRIS', true],
        ['donation', 'qris_merchant', 'GKKD DENPASAR', 'string', 'Nama merchant QRIS', true],

        // Media sosial.
        ['social', 'instagram', 'https://instagram.com/gkkddenpasar', 'string', 'Instagram resmi', true],
        ['social', 'youtube', 'https://youtube.com/@gkkddenpasar', 'string', 'Kanal YouTube resmi', true],
        ['social', 'facebook', 'https://facebook.com/gkkddenpasar', 'string', 'Halaman Facebook resmi', true],
        ['social', 'tiktok', 'https://tiktok.com/@gkkddenpasar', 'string', 'Akun TikTok resmi', true],

        // SEO.
        ['seo', 'meta_description', 'GKKD Denpasar — gereja yang hangat, bertumbuh dalam firman, dan melayani sesama di Bali.', 'text', 'Meta description default', true],
        ['seo', 'meta_keywords', 'GKKD, gereja denpasar, gereja bali, komsel, ibadah', 'string', 'Meta keywords default', true],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->settings as [$group, $key, $value, $type, $description, $isPublic]) {
            AppSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                    'type' => $type,
                    'description' => $description,
                    'is_public' => $isPublic,
                ],
            );
        }
    }
}
