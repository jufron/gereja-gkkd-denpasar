<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Kategori transaksi keuangan (pemasukan / pengeluaran).
 *
 * Tipe transaksi diturunkan dari `type` kategori ini — bukan kolom
 * terpisah di transaksi — sehingga mustahil ada kategori pemasukan
 * yang tercatat sebagai pengeluaran (dan sebaliknya).
 */
#[Table('finance_categories')]
#[Fillable([
    'type',
    'name',
    'code',
    'description',
    'sort_order',
    'is_active',
])]
class FinanceCategory extends Model
{
    use LogsActivity;

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
     * Konfigurasi activity log: catat perubahan kolom penting, hanya yang
     * berubah (dirty), dengan deskripsi event Bahasa Indonesia.
     */
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

    /**
     * Batasi query ke kategori yang aktif.
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
     * Batasi query ke tipe kategori tertentu (income/expense).
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     * @param  string  $tipe  Tipe kategori: 'income' atau 'expense'.
     */
    public function scopeOfType(Builder $query, string $tipe): Builder
    {
        return $query->where('type', $tipe);
    }

    /**
     * Transaksi yang tercatat dalam kategori ini (one-to-many).
     *
     * @return HasMany<FinanceTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(FinanceTransaction::class);
    }
}
