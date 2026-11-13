<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Rangkuman khotbah. Gambar (thumbnail & foto pengkhotbah) tersimpan di
 * tabel media dan dihubungkan lewat asset_usages (kind: thumbnail|preacher).
 */
#[Table('sermons')]
#[Fillable([
    'title',
    'slug',
    'preacher',
    'preached_at',
    'location',
    'content',
    'ppt_url',
    'status',
    'published_at',
])]
class Sermon extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'status', 'published_at', 'preached_at'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Tambah khotbah',
                'updated' => 'Ubah khotbah',
                'deleted' => 'Hapus khotbah',
                default => "Khotbah {$eventName}",
            })
            ->useLogName('khotbah');
    }

    protected $casts = [
        'preached_at' => 'date',
        'published_at' => 'datetime',
        'status' => 'string',
    ];

    public function mediaUsages(): HasMany
    {
        return $this->hasMany(AssetUsage::class);
    }

    /**
     * URL thumbnail utama. null bila tidak diunggah.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUsages
            ->firstWhere('kind', 'thumbnail')
            ?->media?->getUrl());
    }

    /**
     * Inisial nama untuk avatar fallback saat foto tiada.
     */
    protected function preacherInitials(): Attribute
    {
        return Attribute::get(function (): string {
            $initials = collect(explode(' ', trim($this->preacher)))
                ->filter()
                ->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))
                ->take(2)
                ->implode('');

            return $initials ?: '?';
        });
    }

    /**
     * Cuplikan teks untuk kartu, diambil dari isi pembahasan (HTML).
     */
    protected function summary(): Attribute
    {
        return Attribute::get(fn () => Str::limit(strip_tags($this->content), 160));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Slug unik dari judul; bila dipakai, tambah suffix -2, -3, dst.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'khotbah';

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
