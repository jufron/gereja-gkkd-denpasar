<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Mencatat pemakaian satu media oleh satu berita atau satu khotbah.
 *
 * Tepat salah satu pemilik terisi: news_id (berita) atau sermon_id
 * (khotbah). Kind: content|banner (berita), thumbnail|preacher (khotbah).
 * Media tanpa baris pemakaian apa pun dihapus oleh command `media:prune`.
 */
#[Table('asset_usages')]
#[Fillable([
    'media_id',
    'news_id',
    'sermon_id',
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
        'sermon_id' => 'int',
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

    /**
     * Relasi ke khotbah yang memakai media.
     *
     * @return BelongsTo<Sermon, $this>
     */
    public function sermon(): BelongsTo
    {
        return $this->belongsTo(Sermon::class);
    }
}
