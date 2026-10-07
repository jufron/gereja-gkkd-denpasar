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
     * @return array{paginator: LengthAwarePaginator, categories: Collection<int, string>, featured: ?object, kategori: ?string, q: string}
     */
    public function getBeritaData(?string $kategori, string $search, array $queryParams): array;
}
