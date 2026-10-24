<?php

namespace App\Services;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

/**
 * Implementasi pengelolaan berita pada dashboard.
 *
 * Semua aturan bisnis terkait berita terpusat di sini:
 *  - sanitasi HTML konten (Purifier);
 *  - upload / ganti / hapus banner;
 *  - slug unik otomatis;
 *  - perhitungan tanggal terbit (published_at);
 *  - tukar status terbit/draft.
 *
 * Controller dan Livewire cukup memanggil layanan ini, tidak menulis
 * query atau aturan secara langsung.
 */
final class NewsManagementService implements NewsManagementServiceInterface
{
    /**
     * Kunci cache untuk data statistik kartu.
     *
     * Di-flush setiap kali data berita berubah.
     */
    private const CACHE_KEY = 'dashboard.berita.statistik';

    /**
     * Durasi cache statistik dalam detik.
     */
    private const CACHE_TTL = 300;

    /**
     * Ambil daftar berita terfilter.
     *
     * Mendukung pencarian judul/excerpt dan filter status.
     * Hasil diurutkan dari yang terbaru.
     *
     * @param  string  $search  Kata kunci pencarian.
     * @param  string  $status  Status filter ('', 'draft', 'published').
     * @param  int  $perPage  Jumlah data per halaman.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(string $search, string $status, int $perPage = 10): LengthAwarePaginator
    {
        return News::query()
            ->with(['category', 'author'])
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }))
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * Ambil jumlah berita per status.
     *
     * Dipakai untuk kartu statistik di atas tabel. Hasilnya di-cache
     * agar query tidak berulang tiap render, dan di-flush otomatis saat
     * create/update/delete/toggleStatus.
     *
     * @return array{total: int, published: int, draft: int}
     */
    public function statistics(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'total' => News::count(),
                'published' => News::where('status', 'published')->count(),
                'draft' => News::where('status', 'draft')->count(),
            ];
        });
    }

    /**
     * Hapus cache statistik.
     *
     * Dipanggil setelah data berita berubah agar kartu selalu segar.
     */
    private function forgetStatisticsCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Ambil data pendukung untuk form tambah/ubah.
     *
     * @return array{categories: \Illuminate\Database\Eloquent\Collection, news: \App\Models\News}
     */
    public function formData(): array
    {
        return [
            'categories' => NewsCategory::ordered()->get(),
            'news' => new News,
        ];
    }

    /**
     * Simpan berita baru.
     *
     * @param  array<string, mixed>  $data  Data validasi dari form.
     * @return \App\Models\News
     */
    public function create(array $data): News
    {
        $news = new News;

        $this->persist($news, $data);
        $this->forgetStatisticsCache();

        return $news;
    }

    /**
     * Perbarui berita yang ada.
     *
     * @param  \App\Models\News  $news  Berita yang akan diperbarui.
     * @param  array<string, mixed>  $data  Data validasi dari form.
     * @return \App\Models\News
     */
    public function update(News $news, array $data): News
    {
        $this->persist($news, $data);
        $this->forgetStatisticsCache();

        return $news;
    }

    /**
     * Hapus berita beserta file banner-nya.
     *
     * @param  \App\Models\News  $news  Berita yang akan dihapus.
     */
    public function delete(News $news): void
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();
        $this->forgetStatisticsCache();
    }

    /**
     * Tukar status terbit/draft.
     *
     * - published → draft: tanggal terbit dikosongkan;
     * - draft → published: tanggal terbit diisi (sekarang bila belum ada).
     *
     * @param  \App\Models\News  $news  Berita yang statusnya akan ditukar.
     * @return \App\Models\News
     */
    public function toggleStatus(News $news): News
    {
        if ($news->status === 'published') {
            $news->update(['status' => 'draft', 'published_at' => null]);
            activity('berita')->on($news)->log('Berita dijadikan draft');
        } else {
            $news->update([
                'status' => 'published',
                'published_at' => $news->published_at ?? now(),
            ]);
            activity('berita')->on($news)->log('Berita diterbitkan');
        }

        $this->forgetStatisticsCache();

        return $news;
    }

    /**
     * Inti penyimpanan berita.
     *
     * Dipakai oleh create dan update. Urutan pemrosesan:
     *  1. Sanitasi HTML konten;
     *  2. Atur banner: upload baru → hapus yang lama; hapus jika diminta;
     *  3. Generate slug unik (abaikan id sendiri saat update);
     *  4. Hitung tanggal terbit sesuai status;
     *  5. Isi atribut yang boleh diubah + user_id (hanya saat create);
     *  6. Simpan.
     *
     * @param  \App\Models\News  $news  Model berita (baru atau lama).
     * @param  array<string, mixed>  $data  Data validasi dari form.
     */
    private function persist(News $news, array $data): void
    {
        // Amankan konten dari XSS (hapus tag/script berbahaya).
        $contentClean = Purifier::clean($data['content']);

        // Banner upload: pertahankan lama kecuali ada file baru atau minta hapus.
        $bannerPath = $news->featured_image;
        if (! empty($data['banner'])) {
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $data['banner']->store('news/banner', 'public');
        }

        // Hapus banner jika checkbox "hapus banner" dicentang.
        if (! empty($data['hapus_banner']) && $bannerPath) {
            Storage::disk('public')->delete($bannerPath);
            $bannerPath = null;
        }

        // Slug unik dari judul (judul sama → suffix -2, -3, ...).
        $slug = News::uniqueSlug($data['title'], $news->exists ? $news->id : null);

        // Terbit → pakai tanggal yang diberikan, kalau kosong pakai tanggal
        // lama, kalau belum ada pakai sekarang. Draft → pertahankan tanggal lama.
        $publishedAt = $data['status'] === 'published'
            ? ($data['published_at'] ?? ($news->published_at ?? now()))
            : ($news->published_at ?? null);

        // Isi hanya field yang boleh diubah dari input.
        $news->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'news_category_id' => $data['category_id'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $contentClean,
            'featured_image' => $bannerPath,
            'status' => $data['status'],
            'published_at' => $publishedAt,
        ]);

        // user_id hanya diisi saat create (kepemilikan artikel).
        if (! $news->exists) {
            $news->user_id = auth()->id();
        }

        $news->save();
    }
}
