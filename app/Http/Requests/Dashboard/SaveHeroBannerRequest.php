<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi payload form tambah/ubah banner beranda.
 *
 * Dipakai oleh komponen Livewire BannerManager lewat rules()/messages(),
 * dan authorize() dipakai di mount() untuk membatasi akses.
 */
final class SaveHeroBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('Kelola Beranda');
    }

    public function rules(): array
    {
        return [
            'badge' => ['required', 'string', 'min:3', 'max:60'],
            'caption' => ['required', 'string', 'min:3', 'max:160'],
            'alt' => ['required', 'string', 'min:3', 'max:160'],
            'linkUrl' => ['nullable', 'url', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'isActive' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'badge.required' => 'Badge wajib diisi.',
            'badge.min' => 'Badge minimal 3 karakter.',
            'badge.max' => 'Badge maksimal 60 karakter.',
            'caption.required' => 'Caption wajib diisi.',
            'caption.max' => 'Caption maksimal 160 karakter.',
            'alt.required' => 'Teks alternatif (alt) wajib diisi.',
            'alt.max' => 'Teks alt maksimal 160 karakter.',
            'linkUrl.url' => 'Tautan harus berupa URL yang valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran gambar maksimal 5 MB.',
        ];
    }
}
