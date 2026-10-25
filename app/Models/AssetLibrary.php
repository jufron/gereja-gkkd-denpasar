<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Pemilik seluruh file yang diupload (pustaka media).
 *
 * Berperan sebagai pemilik (model) semua aset media supaya file tidak
 * ikut terhapus saat user/news dihapus — penghapusan file hanya terjadi
 * lewat prune (media tanpa pemakaian).
 *
 * Singleton: hanya ada satu baris (id=1). Baris ini tidak boleh dihapus.
 */
#[Table('asset_libraries')]
#[Fillable(['id'])]
class AssetLibrary extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    /**
     * Cegah penghapusan baris singleton (id=1).
     */
    protected static function booted(): void
    {
        static::deleting(function (): never {
            abort(400, 'Aset pustaka media tidak dapat dihapus.');
        });
    }

    /**
     * Ambil (atau buat) baris singleton pustaka media.
     *
     * @return self Instance AssetLibrary singleton.
     */
    public static function singleton(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /**
     * Daftarkan koleksi media beserta konversi thumbnail.
     *
     * - news-content: banyak gambar, thumb 400px webp.
     * - news-banner: satu file, thumb 1200px webp.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news-content')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->registerMediaConversions(function (Media $media): void {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->format('webp');
            });

        $this->addMediaCollection('news-banner')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->registerMediaConversions(function (Media $media): void {
                $this->addMediaConversion('thumb')
                    ->width(1200)
                    ->format('webp');
            });
    }
}
