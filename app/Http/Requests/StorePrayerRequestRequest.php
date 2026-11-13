<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi form publik permohonan doa.
 *
 * Wajib: nama, jenis kelamin, no HP, isi doa.
 * Opsional: alamat, kategori, boleh dihubungi.
 * Honeypot: field "website" harus kosong — isi = bot, tolak.
 */
final class StorePrayerRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'min:2', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'kategori' => ['required', 'in:kesehatan,keluarga,pekerjaan,pelayanan,syukur,lainnya'],
            'isi_doa' => ['required', 'string', 'min:10', 'max:2000'],
            'boleh_dihubungi' => ['nullable', 'boolean'],
            'persetujuan' => ['required', 'accepted'],
            'website' => ['nullable', 'string', 'max:100'], // honeypot: wajib kosong
        ];
    }

    public function messages(): array
    {
        return [
            'persetujuan.accepted' => 'Anda harus menyetujui ketentuan privasi.',
            'nomor_hp.regex' => 'Format nomor HP tidak valid.',
            'isi_doa.min' => 'Tuliskan permohonan doa Anda minimal 10 karakter.',
        ];
    }

    /**
     * True saat honeypot terisi (bot).
     */
    public function isBot(): bool
    {
        return filled($this->input('website'));
    }

    /**
     * Data bersih untuk disimpan, tanpa field honeypot.
     */
    public function prepared(): array
    {
        return [
            'nama_lengkap' => $this->input('nama_lengkap'),
            'jenis_kelamin' => $this->input('jenis_kelamin'),
            'nomor_hp' => $this->input('nomor_hp'),
            'alamat' => $this->input('alamat'),
            'kategori' => $this->input('kategori'),
            'isi_doa' => $this->input('isi_doa'),
            'boleh_dihubungi' => $this->boolean('boleh_dihubungi'),
            'ip_address' => $this->ip(),
            'user_agent' => substr((string) $this->userAgent(), 0, 255),
        ];
    }
}
