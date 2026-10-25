<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Ponytail: belum ada factory — pakai create langsung di test sekolah.
 * Tambahkan factory bila butuh seeder publik / load test heavy.
 */
#[Table('news')]
#[Fillable([
    'news_category_id',
    'user_id',
    'title',
    'slug',
    'excerpt',
    'content',
    'status',
    'published_at',
])]
class News extends Model
{
    use HasFactory, LogsActivity;

    /**
     * Buat factory khusus model News agar factory bawaan Laravel dapat dipakai.
     */
    protected static function newFactory(): NewsFactory
    {
        return NewsFactory::new();
    }

    /**
     * Konfigurasi activity log: catat perubahan pada kolom penting saja,
     * hanya yang berubah (dirty), dan beri deskripsi event dalam Bahasa Indonesia.
     */
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

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Hubungan dengan kategori berita (many-to-one).
     *
     * @return BelongsTo<NewsCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    /**
     * Hubungan dengan penulis / pembuat berita (many-to-one).
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan dengan media yang dipakai berita ini.
     *
     * @return HasMany<AssetUsage, $this>
     */
    public function mediaUsages(): HasMany
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

    /**
     * Scope: ambil berita berstatus published yang sudah dijadwalkan tayang.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope: ambil hanya berita berstatus draft.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Buat slug unik dari judul; bila sudah dipakai, tambah suffix -2, -3, dst.
     *
     * @param  string  $title  Judul berita sebagai basis slug.
     * @param  int|null  $ignoreId  ID record yang diabaikan saat cek konflik (untuk update).
     * @return string Slug unik yang belum dipakai.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'berita';

        $taken = self::query()
            ->where(fn ($q) => $q->where('slug', $base)->orWhere('slug', 'like', $base.'-%'))
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->pluck('slug');

        if (! $taken->contains($base)) {
            return $base;
        }

        $next = max(1, $taken
            ->map(fn (string $slug) => (int) Str::after($slug, $base.'-'))
            ->max()) + 1;

        return $base.'-'.$next;
    }
}
