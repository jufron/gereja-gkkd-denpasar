<?php

namespace App\Models;

use Database\Factories\NewsCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Kategori berita (mis. Ibadah, Pengumuman, Renungan).
 */
#[Table('news_categories')]
#[Fillable([
    'name',
    'slug',
    'color',
    'description',
    'sort_order',
    'is_active',
])]
class NewsCategory extends Model
{
    /** @use HasFactory<NewsCategoryFactory> */
    use HasFactory, LogsActivity;

    /**
     * Konfigurasi activity log.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'color', 'description', 'sort_order', 'is_active'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Tambah kategori berita',
                'updated' => 'Ubah kategori berita',
                'deleted' => 'Hapus kategori berita',
                default => "Kategori berita {$eventName}",
            })
            ->useLogName('berita');
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Batasi query ke kategori yang aktif ditampilkan.
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Urutkan kategori sesuai sort_order lalu nama.
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Berita yang termasuk dalam kategori ini (one-to-many).
     *
     * @return HasMany<News, $this>
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
