<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi payload form tambah/ubah rangkuman khotbah.
 *
 * Satu request dipakai untuk store dan update karena aturan field identik.
 */
final class SaveSermonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('Kelola Khotbah');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'preacher' => ['required', 'string', 'max:200'],
            'preached_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'ppt_url' => ['nullable', 'url', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hapus_thumbnail' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
