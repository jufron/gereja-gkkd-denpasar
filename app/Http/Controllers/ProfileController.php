<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil jemaat milik user yang sedang login.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile', [
            'user' => $request->user(),
            'profile' => $request->user()->profile ?? new Profile,
        ]);
    }

    /**
     * Simpan atau perbarui profil jemaat (one-to-one dengan user).
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_anggota' => ['required', 'in:aktif,nonaktif,pindah,meninggal'],
            'tanggal_bergabung' => ['nullable', 'date'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $data['wa_consent'] = $request->boolean('wa_consent');

        $request->user()->profile()->updateOrCreate([], $data);

        return back()->with('status', 'Profil jemaat berhasil diperbarui.');
    }
}
