<?php

namespace App\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface NewsServiceInterface
{
    /**
     * Susun data halaman berita: artikel terfilter + paginator.
     *
     * @param  array<string, mixed>  $queryParams  Query string mentah untuk link paginasi.
     * @return array{paginator: LengthAwarePaginator, categories: Collection<int, object>, featured: ?object, kategori: ?string, q: string}
     */
    public function getBeritaData(?string $kategori, string $search, array $queryParams): array;

    /**
     * Ambil satu berita published beserta relasi dan artikel terkait.
     *
     * @return array{news: object, related: Collection<int, object>, categories: Collection<int, object>}
     */
    public function getBeritaDetail(string $slug): array;
}
