<?php

namespace App\Services;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Models\AssetLibrary;
use App\Models\AssetUsage;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Mews\Purifier\Facades\Purifier;

/**
 * Implementasi pengelolaan berita pada dashboard.
 *
 * Semua aturan bisnis terkait berita terpusat di sini:
 *  - sanitasi HTML konten (Purifier);
 *  - upload / ganti / hapus banner (media library);
 *  - sinkronisasi pemakaian media pada konten & banner (AssetUsage);
 *  - slug unik otomatis;
 *  - perhitungan tanggal terbit (published_at);
 *  - tukar status terbit/draft.
 *
 * File media TIDAK dihapus di sini; yang dihapus hanya relasi pemakaian.
 * File tanpa pemakaian dibersihkan oleh command `media:prune`.
 */
final class NewsManagementService implements NewsManagementServiceInterface
{
    private const CACHE_KEY = 'dashboard.berita.statistik';

    private const CACHE_TTL = 300;

    public function paginate(string $search, string $status, int $perPage = 10): LengthAwarePaginator
    {
        return News::query()
            ->with(['category', 'author', 'mediaUsages.media'])
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }))
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate($perPage);
    }

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

    private function forgetStatisticsCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function formData(): array
    {
        return [
            'categories' => NewsCategory::ordered()->get(),
            'news' => new News,
        ];
    }

    public function create(array $data): News
    {
        $news = new News;

        $this->persist($news, $data);
        $this->forgetStatisticsCache();

        return $news;
    }

    public function update(News $news, array $data): News
    {
        $this->persist($news, $data);
        $this->forgetStatisticsCache();

        return $news;
    }

    /**
     * Hapus berita. Relasi pemakaian media ikut terhapus (cascade);
     * file media tetap ada sampai prune.
     */
    public function delete(News $news): void
    {
        $news->delete();
        $this->forgetStatisticsCache();
    }

    public function toggleStatus(News $news): News
    {
        if ($news->status === 'published') {
            $news->fill(['status' => 'draft', 'published_at' => null])->saveQuietly();
            activity('berita')->on($news)->log('Berita dijadikan draft');
        } else {
            $news->fill([
                'status' => 'published',
                'published_at' => $news->published_at ?? now(),
            ])->saveQuietly();
            activity('berita')->on($news)->log('Berita diterbitkan');
        }

        $this->forgetStatisticsCache();

        return $news;
    }

    private function persist(News $news, array $data): void
    {
        $contentClean = Purifier::clean($data['content']);

        $slug = News::uniqueSlug($data['title'], $news->exists ? $news->id : null);

        $publishedAt = $data['status'] === 'published'
            ? ($data['published_at'] ?? ($news->published_at ?? now()))
            : ($news->published_at ?? null);

        $news->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'news_category_id' => $data['category_id'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $contentClean,
            'status' => $data['status'],
            'published_at' => $publishedAt,
        ]);

        if (! $news->exists) {
            $news->user_id = auth()->id();
        }

        $news->save();

        if (! empty($data['banner'])) {
            $this->setBanner($news, $data['banner']);
        } elseif (! empty($data['hapus_banner'])) {
            $this->setBanner($news, null);
        }

        $this->syncContentUsages($news, $contentClean);
    }

    /**
     * Atur banner artikel. Upload baru → media baru + usage; null → lepas usage
     * (file lama jadi yatim, di-bersihkan prune).
     */
    private function setBanner(News $news, mixed $file): void
    {
        AssetUsage::where('news_id', $news->id)->where('kind', 'banner')->delete();

        if ($file === null) {
            return;
        }

        $library = AssetLibrary::singleton();
        $media = $library->addMedia($file)->toMediaCollection('news-banner');

        AssetUsage::create([
            'news_id' => $news->id,
            'media_id' => $media->id,
            'kind' => 'banner',
        ]);
    }

    /**
     * Sinkronkan pemakaian gambar konten dengan media yang benar-benar
     * muncul di HTML. Gambar yang dihapus dari editor otomatis lepas.
     */
    private function syncContentUsages(News $news, string $html): void
    {
        $ids = $this->mediaIdsFromHtml($html);

        if ($ids === []) {
            AssetUsage::where('news_id', $news->id)
                ->where('kind', 'content')
                ->delete();
        } else {
            AssetUsage::where('news_id', $news->id)
                ->where('kind', 'content')
                ->whereNotIn('media_id', $ids)
                ->delete();

            foreach ($ids as $id) {
                AssetUsage::updateOrCreate(
                    ['news_id' => $news->id, 'kind' => 'content', 'media_id' => $id],
                );
            }
        }
    }

    /**
     * Ambil id media dari URL gambar pada konten.
     * Path media library berbentuk .../media/{id}/nama-file.ext
     */
    private function mediaIdsFromHtml(string $html): array
    {
        preg_match_all('#/media/(\d+)/#', $html, $matches);

        return array_values(array_unique(array_map('intval', $matches[1])));
    }
}
