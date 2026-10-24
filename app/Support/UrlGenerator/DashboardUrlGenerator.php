<?php

namespace App\Support\UrlGenerator;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

/**
 * Hasilkan URL media yang stabil tanpa peduli disk aktif (lokal / R2).
 *
 * Selalu kembali ke `/media/{id}/{file}` (original) atau
 * `/media/{id}/conversions/{conv}` (konversi). Route publik `media/{media}/{path}`
 * meng-stream file dari disk yang sedang dipakai. Memungkinkan migrasi disk
 * tanpa mengubah URL di konten berita.
 */
class DashboardUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        return $this->versionUrl('/media/'.$this->getUrlEncodedPathRelativeToRoot());
    }
}
