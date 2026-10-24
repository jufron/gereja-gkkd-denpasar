<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Satu baris buku kas (pemasukan atau pengeluaran).
 *
 * Tipe masuk/keluar ditentukan lewat relasi ke FinanceCategory. Transaksi
 * yang salah input tidak dihapus; di-void supaya jejak keuangan tetap utuh.
 */
class FinanceTransaction extends Model
{
    use LogsActivity;

    protected $fillable = [
        'finance_category_id',
        'transaction_date',
        'amount',
        'description',
        'reference_no',
        'status',
        'voided_at',
        'void_reason',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'int',
            'voided_at' => 'datetime',
        ];
    }

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

    public function category()
    {
        return $this->belongsTo(FinanceCategory::class, 'finance_category_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }
}
