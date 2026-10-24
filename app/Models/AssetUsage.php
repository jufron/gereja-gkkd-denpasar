<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mencatat pemakaian satu media oleh satu berita.
 *
 * media_id + news_id + kind (content|banner) unik. Media tanpa baris
 * pemakaian apa pun dihapus oleh command `media:prune` setelah grace period.
 */
class AssetUsage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'media_id' => 'int',
        'news_id' => 'int',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
