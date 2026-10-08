<?php

namespace App\Contracts\Services;

interface HomeContentServiceInterface
{
    /**
     * Susun seluruh data untuk halaman utama.
     *
     * @return array<string, mixed>
     */
    public function getHomeData(): array;
}
