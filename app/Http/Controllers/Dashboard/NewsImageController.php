<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssetLibrary;
use Illuminate\Http\Request;

/**
 * Handler upload gambar inline di dalam editor Quill.
 * File disimpan ke media library (koleksi news-content), pemilik AssetLibrary.
 * URL publik dihasilkan dari disk media (lokal / R2).
 * Akses: role admin + permission "Kelola Berita" (via route middleware).
 */
final class NewsImageController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $media = AssetLibrary::singleton()
            ->addMedia($data['upload'])
            ->toMediaCollection('news-content');

        return response()->json([
            'url' => $media->getUrl(),
            'id' => $media->id,
        ]);
    }
}
