<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreSermonEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tahunIni = (int) now()->year;

        return [
            'nama' => ['nullable', 'string', 'max:100'],
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'between:'.($tahunIni - 1).','.($tahunIni + 1)],
            'rating' => ['required', 'integer', 'between:1,5'],
            'berkesan' => ['nullable', 'string', 'max:2000'],
            'masukan' => ['nullable', 'string', 'max:2000'],
            'persetujuan' => ['required', 'accepted'],
            'website' => ['nullable', 'string', 'max:100'], // honeypot
        ];
    }

    public function messages(): array
    {
        return [
            'persetujuan.accepted' => 'Anda harus menyetujui ketentuan privasi.',
            'rating.required' => 'Pilih penilaian Anda untuk bulan ini.',
        ];
    }

    public function isBot(): bool
    {
        return filled($this->input('website'));
    }

    public function prepared(): array
    {
        return [
            'nama' => $this->input('nama'),
            'bulan' => (int) $this->input('bulan'),
            'tahun' => (int) $this->input('tahun'),
            'rating' => (int) $this->input('rating'),
            'berkesan' => $this->input('berkesan'),
            'masukan' => $this->input('masukan'),
            'ip_address' => $this->ip(),
            'user_agent' => substr((string) $this->userAgent(), 0, 255),
        ];
    }
}
