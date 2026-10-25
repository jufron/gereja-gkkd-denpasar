<?php

namespace App\Models;

use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Jadwal ibadah/kegiatan gereja.
 */
#[Table('schedules')]
#[Fillable([
    'badge_id',
    'title',
    'time',
    'day',
    'description',
    'sort_order',
    'is_active',
])]
class Schedule extends Model
{
    /** @use HasFactory<ScheduleFactory> */
    use HasFactory;

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
     * Badge kategori jadwal (many-to-one).
     *
     * @return BelongsTo<Badge, $this>
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Batasi query ke jadwal yang aktif ditampilkan.
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
