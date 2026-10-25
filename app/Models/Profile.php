<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Profil jemaat milik satu akun user (one-to-one).
 */
#[Table('profiles')]
#[Fillable([
    'user_id',
    'nama_lengkap',
    'jenis_kelamin',
    'tanggal_lahir',
    'alamat',
    'status_anggota',
    'tanggal_bergabung',
    'no_hp',
    'wa_consent',
    'wa_verified_at',
])]
class Profile extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_bergabung' => 'date',
            'wa_consent' => 'boolean',
            'wa_verified_at' => 'datetime',
        ];
    }

    /**
     * Akun pemilik profil (many-to-one).
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
