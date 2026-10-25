<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Mencatat pemakaian satu media oleh satu berita.
 *
 * media_id + news_id + kind (content|banner) unik. Media tanpa baris
 * pemakaian apa pun dihapus oleh command `media:prune` setelah grace period.
 */
#[Table('asset_usages')]
#[Fillable([
    'media_id',
    'news_id',
    'kind',
])]
class AssetUsage extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'media_id' => 'int',
        'news_id' => 'int',
    ];

    /**
     * Relasi ke media yang dipakai oleh berita.
     *
     * @return BelongsTo<Media, $this>
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Relasi ke berita yang memakai media.
     *
     * @return BelongsTo<News, $this>
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
