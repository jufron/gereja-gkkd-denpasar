<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display all users with search and OAuth provider filters.
     *
     * Satu user dapat terhubung ke beberapa provider sekaligus (mis. Google +
     * Facebook) atau tidak sama sekali (email biasa), sehingga filter provider
     * ditangani lewat relasi socialAccounts, bukan satu kolom di tabel users.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->with(['roles', 'socialAccounts'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->q}%")
                        ->orWhere('email', 'like', "%{$request->q}%");
                });
            })
            ->when($request->filled('provider'), function ($query) use ($request) {
                $request->provider === 'lokal'
                    ? $query->whereDoesntHave('socialAccounts')
                    : $query->whereHas('socialAccounts', fn ($q) => $q->where('provider', $request->provider));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.all-user', [
            'users' => $users,
            'filters' => $request->only(['q', 'provider']),
        ]);
    }
}
