<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Gatekeeper dashboard: arahkan user sesuai rolenya.
     *
     * Administrator     -> /admin
     * Tim Pelayanan     -> /pelayanan
     * Role lain / tamu  -> beranda (tidak diberi dashboard)
     */
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        if ($user?->hasRole('Administrator')) {
            return redirect()->route('admin.index');
        }

        if ($user?->hasRole('Tim Pelayanan')) {
            return redirect()->route('pelayanan.index');
        }

        session()->forget('url.intended');

        return redirect()->route('home');
    }
}
