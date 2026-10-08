<?php

namespace App\Models;

use Database\Factories\AppSettingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    /** @use HasFactory<AppSettingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'description',
        'is_public',
    ];

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
     */
    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    /**
     * Batasi query ke pengaturan yang boleh diakses frontend.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Nilai yang sudah dikonversi sesuai kolom "type".
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
     * Ambil nilai pengaturan berdasarkan key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('key', $key)->first();

        return $setting?->typedValue() ?? $default;
    }

    /**
     * Simpan (buat/perbarui) nilai pengaturan berdasarkan key.
     */
    public static function setValue(string $key, mixed $value, ?string $type = null): self
    {
        $setting = static::query()->firstOrNew(['key' => $key]);

        $type ??= $setting->type ?? 'string';

        $setting->fill([
            'value' => is_array($value) ? json_encode($value) : (string) $value,
            'type' => $type,
        ])->save();

        return $setting;
    }
}
