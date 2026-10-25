<?php

namespace App\Models;

use Database\Factories\BadgeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Badge penanda jadwal (mis. warna kategori).
 */
#[Table('badges')]
#[Fillable([
    'name',
    'slug',
    'color',
])]
class Badge extends Model
{
    /** @use HasFactory<BadgeFactory> */
    use HasFactory;

    /**
     * Jadwal yang memakai badge ini (one-to-many).
     *
     * @return HasMany<Schedule, $this>
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
