<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Kategori transaksi keuangan (pemasukan / pengeluaran).
 *
 * Tipe transaksi diturunkan dari `type` kategori ini — bukan kolom
 * terpisah di transaksi — sehingga mustahil ada kategori pemasukan
 * yang tercatat sebagai pengeluaran (dan sebaliknya).
 */
class FinanceCategory extends Model
{
    use LogsActivity;

    protected $fillable = [
        'type',
        'name',
        'code',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type', 'name', 'code', 'description', 'sort_order', 'is_active'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Tambah kategori keuangan',
                'updated' => 'Ubah kategori keuangan',
                'deleted' => 'Hapus kategori keuangan',
                default => "Kategori keuangan {$eventName}",
            })
            ->useLogName('keuangan');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeOfType(Builder $query, string $tipe): Builder
    {
        return $query->where('type', $tipe);
    }

    public function transactions()
    {
        return $this->hasMany(FinanceTransaction::class);
    }
}
