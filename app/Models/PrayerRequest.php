<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Table('prayer_requests')]
#[Fillable([
    'nama_lengkap',
    'jenis_kelamin',
    'nomor_hp',
    'alamat',
    'kategori',
    'isi_doa',
    'boleh_dihubungi',
    'status',
    'catatan_internal',
    'didoakan_pada',
    'ip_address',
    'user_agent',
])]
class PrayerRequest extends Model
{
    use LogsActivity, SoftDeletes;

    /**
     * Konfigurasi activity log: catat perubahan status saja, hanya yang
     * berubah (dirty), dengan deskripsi event Bahasa Indonesia.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Doa baru masuk',
                'updated' => 'Ubah status doa',
                'deleted' => 'Doa dipindah ke sampah',
                'restored' => 'Doa dipulihkan',
                default => "Doa {$eventName}",
            })
            ->useLogName('doa');
    }

    public const KATEGORI = [
        'kesehatan' => 'Kesehatan',
        'keluarga' => 'Keluarga',
        'pekerjaan' => 'Pekerjaan',
        'pelayanan' => 'Pelayanan',
        'syukur' => 'Syukur',
        'lainnya' => 'Lainnya',
    ];

    public const STATUS = [
        'baru' => 'Baru',
        'diproses' => 'Diproses',
        'selesai' => 'Sudah didoakan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'boleh_dihubungi' => 'boolean',
            'didoakan_pada' => 'datetime',
        ];
    }

    /**
     * Label kategori doa yang dapat dibaca manusia.
     */
    protected function kategoriLabel(): Attribute
    {
        return Attribute::get(fn () => self::KATEGORI[$this->kategori] ?? $this->kategori);
    }

    /**
     * Label status doa yang dapat dibaca manusia.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUS[$this->status] ?? $this->status);
    }

    /**
     * Filter doa berdasarkan pencarian, status, dan kategori.
     *
     * @param  Builder  $q  Query Eloquent yang sedang dibangun.
     * @param  string  $cari  Kata kunci pencarian (nama, nomor HP, isi doa).
     * @param  string  $status  Status doa (baru/diproses/selesai).
     * @param  string  $kategori  Kategori doa.
     */
    public function scopeFilter(Builder $q, string $cari = '', string $status = '', string $kategori = ''): Builder
    {
        return $q
            ->when($cari !== '', fn ($b) => $b->where(function ($b) use ($cari) {
                $b->where('nama_lengkap', 'like', "%{$cari}%")
                    ->orWhere('nomor_hp', 'like', "%{$cari}%")
                    ->orWhere('isi_doa', 'like', "%{$cari}%");
            }))
            ->when($status !== '', fn ($b) => $b->where('status', $status))
            ->when($kategori !== '', fn ($b) => $b->where('kategori', $kategori));
    }
}
