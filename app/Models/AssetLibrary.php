<?php

namespace App\Models;

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
class AssetLibrary extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (): never {
            abort(400, 'Aset pustaka media tidak dapat dihapus.');
        });
    }

    public static function singleton(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

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
