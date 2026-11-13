<?php

namespace App\Services;

use App\Contracts\Services\NewsServiceInterface;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NewsService implements NewsServiceInterface
{
    /**
     * Susun data halaman berita: artikel terfilter + paginator.
     *
     * @param  array<string, mixed>  $queryParams  Query string mentah untuk link paginasi.
     * @return array{paginator: LengthAwarePaginator, categories: Collection<int, object>, featured: ?News, kategori: ?string, q: string}
     */
    public function getBeritaData(?string $kategori, string $search, array $queryParams): array
    {
        $categories = NewsCategory::active()->ordered()->get();

        $news = News::query()
            ->with(['category', 'author', 'mediaUsages.media'])
            ->published()
            ->when($kategori, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $kategori)))
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            }))
            ->latest('published_at');

        $paginator = $news->paginate(9)->withQueryString()->fragment('warta');

        $featured = (! $kategori && $search === '' && $paginator->onFirstPage())
            ? $paginator->getCollection()->shift()
            : null;

        return [
            'paginator' => $paginator,
            'categories' => $categories,
            'featured' => $featured,
            'kategori' => $kategori,
            'q' => $search,
        ];
    }

    /**
     * Ambil satu berita published beserta relasi dan artikel terkait.
     *
     * @return array{news: News, related: Collection<int, News>, categories: Collection<int, NewsCategory>}
     */
    public function getBeritaDetail(string $slug): array
    {
        $news = News::query()
            ->with(['category', 'author', 'mediaUsages.media'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = News::query()
            ->with(['category', 'mediaUsages.media'])
            ->published()
            ->whereKeyNot($news->getKey())
            ->when($news->category_id, fn ($q) => $q->orderByRaw(
                'CASE WHEN news_category_id = ? THEN 0 ELSE 1 END',
                [$news->category_id]
            ))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return [
            'news' => $news,
            'related' => $related,
            'categories' => NewsCategory::active()->ordered()->get(),
        ];
    }
}
