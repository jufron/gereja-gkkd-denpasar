<?php

namespace App\Models;

use Database\Factories\AppSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Table('app_settings')]
#[Fillable([
    'group',
    'key',
    'value',
    'type',
    'description',
    'is_public',
])]
class AppSetting extends Model
{
    /** @use HasFactory<AppSettingFactory> */
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Batasi query ke satu kategori pengaturan.
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     * @param  string  $group  Nama grup pengaturan (misal 'seo', 'sosmed').
     */
    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    /**
     * Batasi query ke pengaturan yang boleh diakses frontend.
     *
     * @param  Builder  $query  Query Eloquent yang sedang dibangun.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Nilai yang sudah dikonversi sesuai kolom "type".
     *
     * @return mixed Nilai yang sudah dikonversi (int, bool, array, atau string).
     */
    public function typedValue(): mixed
    {
        return match ($this->type) {
            'integer' => (int) $this->value,
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'json', 'array' => json_decode((string) $this->value, true),
            default => $this->value,
        };
    }

    /**
     * Ambil nilai pengaturan berdasarkan key (dengan cache).
     *
     * Memakai Cache::flexible() — pola stale-while-revalidate:
     * 1 jam pertama data dianggap fresh (langsung dari cache), sampai 24 jam
     * berikutnya data basi tetap disajikan sambil di-refresh di background.
     * Cocok untuk setting yang jarang berubah.
     *
     * @param  string  $key  Nama key pengaturan (unik).
     * @param  mixed  $default  Nilai fallback bila pengaturan tidak ada.
     * @return mixed Nilai yang sudah dikonversi, atau $default bila tidak ditemukan.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        return Cache::flexible(
            "app_setting:$key",
            [3600, 86400], // fresh 1 jam, basi sampai 24 jam
            fn () => static::query()->where('key', $key)->first()?->typedValue() ?? $default,
        );
    }

    /**
     * Simpan (buat/perbarui) nilai pengaturan berdasarkan key.
     *
     * Cache key terkait dihapus agar nilai baru langsung terbaca.
     *
     * @param  string  $key  Nama key pengaturan.
     * @param  mixed  $value  Nilai yang disimpan (array otomatis di-encode ke JSON).
     * @param  string|null  $type  Tipe penyimpanan ('string', 'integer', 'boolean', 'json'/'array').
     * @return self Instance AppSetting yang tersimpan.
     */
    public static function setValue(string $key, mixed $value, ?string $type = null): self
    {
        $setting = static::query()->firstOrNew(['key' => $key]);

        $type ??= $setting->type ?? 'string';

        $setting->fill([
            'value' => is_array($value) ? json_encode($value) : (string) $value,
            'type' => $type,
        ])->save();

        Cache::forget("app_setting:$key");

        return $setting;
    }
}
