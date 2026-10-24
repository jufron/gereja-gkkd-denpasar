<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi payload form tambah/ubah berita.
 *
 * Satu request dipakai untuk store dan update karena aturan field identik.
 */
final class SaveNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('Kelola Berita');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'category_id' => ['nullable', 'exists:news_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'hapus_banner' => ['nullable', 'boolean'],
        ];
    }
}
