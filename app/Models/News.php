<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Ponytail: belum ada factory — pakai create langsung di test sekolah.
 * Tambahkan factory bila butuh seeder publik / load test heavy.
 */
class News extends Model
{
    use HasFactory, LogsActivity;

    protected static function newFactory(): NewsFactory
    {
        return NewsFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'status', 'published_at', 'news_category_id', 'user_id'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Tambah berita',
                'updated' => 'Ubah berita',
                'deleted' => 'Hapus berita',
                default => "Berita {$eventName}",
            })
            ->useLogName('berita');
    }

    protected $fillable = [
        'news_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mediaUsages()
    {
        return $this->hasMany(AssetUsage::class);
    }

    /**
     * URL banner artikel dari media library (koleksi news-banner).
     */
    protected function bannerUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUsages
            ->firstWhere('kind', 'banner')
            ?->media?->getUrl());
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    // Slug unique dengan suffix -2,-3 ...
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'berita';
        $slug = $base;
        $suffix = 2;

        while (
            self::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
