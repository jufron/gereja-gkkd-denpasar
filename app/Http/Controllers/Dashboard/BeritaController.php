<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\News;

final class BeritaController extends Controller
{
    public function index()
    {
        $berita = News::with('category', 'author')
            ->orderByDesc('id')
            ->paginate(15, ['*'], 'page', request('page', 1));

        return view('dashboard.berita', [
            'berita' => $berita,
        ]);
    }
}
