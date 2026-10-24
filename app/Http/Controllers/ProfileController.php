<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use DeviceDetector\DeviceDetector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Stevebauman\Location\Facades\Location;

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

    /**
     * Daftar perangkat (sesi) milik user yang sedang login.
     */
    public function security(Request $request): View
    {
        $currentSessionId = $request->session()->getId();

        $devices = DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => $this->deviceFromSession($session, $currentSessionId))
            ->values();

        return view('dashboard.security', compact('devices'));
    }

    /**
     * Akhiri sesi perangkat lain (bukan sesi saat ini).
     */
    public function destroySession(Request $request, string $token): RedirectResponse
    {
        $session = DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->get()
            ->first(fn ($s) => hash_equals($this->sessionToken($s->id), $token));

        if (! $session || $session->id === $request->session()->getId()) {
            abort(404);
        }

        DB::table('sessions')->where('id', $session->id)->delete();

        return back()->with('status', 'Sesi perangkat lain telah diakhiri.');
    }

    private function deviceFromSession(object $session, string $currentSessionId): array
    {
        $current = $session->id === $currentSessionId;

        $detector = new DeviceDetector($session->user_agent ?? '');
        $detector->parse();

        return [
            'token' => $this->sessionToken($session->id),
            'browser' => $detector->getClient('name') ?: 'Browser',
            'os' => $detector->getOs('name') ?: 'Sistem Operasi',
            'type' => $detector->isMobile() ? 'mobile' : 'desktop',
            'ip' => $session->ip_address,
            'location' => $this->resolveLocation($session->ip_address),
            'last_active' => $current
                ? 'Saat ini'
                : Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            'current' => $current,
        ];
    }

    private function resolveLocation(?string $ip): string
    {
        if (! $ip || ! filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'Jaringan Lokal';
        }

        $isPrivate = filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false;

        if ($isPrivate) {
            return 'Jaringan Lokal';
        }

        $position = Cache::remember("geo:$ip", 86400, fn () => Location::get($ip));

        if ($position && $position->cityName) {
            return trim($position->cityName.', '.$position->regionName, ', ');
        }

        return 'Lokasi tidak diketahui';
    }

    private function sessionToken(string $id): string
    {
        return hash_hmac('sha256', $id, config('app.key'));
    }
}
