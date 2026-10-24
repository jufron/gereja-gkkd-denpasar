<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Handler upload gambar inline di dalam editor Quill.
 * File disimpan ke disk "public" (folder news/content) sehingga
 * tidak ada base64 yang bocor ke database.
 * Akses: role admin + permission "Kelola Berita".
 */
final class NewsImageController extends Controller
{
    public function __invoke(Request $request)
    {
        $path = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ])['upload']->store('news/content', 'public');

        return response()->json([
            'url' => '/storage/'.$path,
        ]);
    }
}
