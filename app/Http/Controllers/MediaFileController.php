<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Sajikan file media (original / konversi) dari disk yang sedang dipakai.
 *
 * Route publik `/media/{media}/{path}`. URL dihasilkan oleh
 * DashboardUrlGenerator. File tidak di-serve langsung oleh web server, tapi
 * lewat Laravel — cukup untuk trafik gereja; upgrade nginx X-Accel bila perlu.
 */
final class MediaFileController extends Controller
{
    public function __invoke(Media $media, string $path)
    {
        $isConversion = str_starts_with($path, 'conversions/');

        $diskName = $isConversion
            ? ($media->conversions_disk ?? $media->disk)
            : $media->disk;

        $disk = Storage::disk($diskName);

        $relative = $media->id.'/'.$path;

        abort_unless($disk->exists($relative), 404);

        return $disk->response($relative);
    }
}
