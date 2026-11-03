<?php

namespace App\Models;

use Database\Factories\HeroBannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Banner slider pada hero halaman utama.
 *
 * File fisik berasal dari pustaka media (pemilik: AssetLibrary singleton).
 * Tabel ini menyimpan metadata tampilan dan nilai media_id.
 */
#[Table('hero_banners')]
#[Fillable([
    'media_id',
    'badge',
    'caption',
    'alt',
    'link_url',
    'sort_order',
    'is_active',
])]
class HeroBanner extends Model
{
    /** @use HasFactory<HeroBannerFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
