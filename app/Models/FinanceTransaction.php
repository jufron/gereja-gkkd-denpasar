<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Satu baris buku kas (pemasukan atau pengeluaran).
 *
 * Tipe masuk/keluar ditentukan lewat relasi ke FinanceCategory. Transaksi
 * yang salah input tidak dihapus; di-void supaya jejak keuangan tetap utuh.
 */
#[Table('finance_transactions')]
#[Fillable([
    'finance_category_id',
    'transaction_date',
    'amount',
    'description',
    'reference_no',
    'status',
    'voided_at',
    'void_reason',
    'created_by',
])]
class FinanceTransaction extends Model
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
            'transaction_date' => 'date',
            'amount' => 'int',
            'voided_at' => 'datetime',
        ];
    }

    /**
     * Konfigurasi activity log: catat perubahan kolom penting, hanya yang
     * berubah (dirty), dengan deskripsi event Bahasa Indonesia.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['finance_category_id', 'transaction_date', 'amount', 'description', 'reference_no', 'status'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Catat transaksi keuangan',
                'updated' => 'Ubah transaksi keuangan',
                'deleted' => 'Hapus transaksi keuangan',
                default => "Transaksi keuangan {$eventName}",
            })
            ->useLogName('keuangan');
    }

    /**
     * Kategori keuangan dari transaksi ini (many-to-one).
     *
     * @return BelongsTo<FinanceCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FinanceCategory::class, 'finance_category_id');
    }

    /**
     * Pengguna yang mencatat transaksi ini (many-to-one).
     *
     * @return BelongsTo<User, $this>
     */
    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Batasi query ke transaksi berstatus posted (belum di-void).
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     */
    public function scopePosted(Builder $query): Builder
    {
        return $query->where('status', 'posted');
    }
}
