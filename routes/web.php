<?php

use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PrayerRequestController;
use App\Http\Controllers\SermonEvaluationController;
use App\Models\News;
use App\Models\Sermon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
|
| Route halaman publik (front-end). Route dashboard ada di
| routes/dashboard.php dan route auth ada di routes/auth.php.
|
*/

Route::get('sitemap.xml', function () {
    $static = [
        route('home'),
        route('tentang'),
        route('berita'),
        route('galeri'),
        route('kontak'),
        route('kebijakan-privasi'),
        route('kegiatan.index'),
        route('kegiatan.pelayanan'),
        route('kegiatan.pelayanan.multimedia'),
        route('kegiatan.komsel'),
        route('kegiatan.retret-camp'),
    ];

    $urls = collect($static)
        ->merge(News::query()->published()->pluck('slug')->map(fn ($slug) => route('berita.show', $slug)))
        ->merge(Sermon::query()->published()->pluck('slug')->map(fn ($slug) => route('kegiatan.khotbah.show', $slug)))
        ->unique()
        ->values();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
        .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
        .$urls->map(fn ($loc) => '  <url><loc>'.e($loc).'</loc></url>')->implode("\n")
        ."\n</urlset>\n";

    return response($xml)->header('Content-Type', 'application/xml');
});

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('tentang', 'tentang')->name('tentang');
    Route::get('berita', 'berita')->name('berita');
    Route::get('berita/{news:slug}', 'beritaShow')->name('berita.show');
    Route::get('galeri', 'galeri')->name('galeri');
    Route::get('kontak', 'kontak')->name('kontak');
    Route::view('kebijakan-privasi', 'kebijakan-privasi')->name('kebijakan-privasi');

    // Permohonan doa — publik, tanpa login. Throttle cegah spam.
    Route::prefix('doa')->controller(PrayerRequestController::class)->name('doa')->group(function () {
        Route::get('/', 'create');
        Route::post('/', 'store')->middleware('throttle:5,1')->name('.kirim');
    });

    // Evaluasi khotbah bulanan — publik, tanpa login.
    Route::prefix('evaluasi-khotbah')->controller(SermonEvaluationController::class)->name('evaluasi-khotbah')->group(function () {
        Route::get('/', 'create');
        Route::post('/', 'store')->middleware('throttle:5,1')->name('.kirim');
    });

    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', 'kegiatanIndex')->name('index');
        Route::get('pelayanan', 'pelayanan')->name('pelayanan');
        Route::view('pelayanan/multimedia', 'kegiatan.pelayanan-multimedia')->name('pelayanan.multimedia');
        Route::get('pelayanan/{slug}', 'pelayananShow')->name('pelayanan.show');
        Route::get('komsel', 'komsel')->name('komsel');
        Route::get('retret-camp', 'retretCamp')->name('retret-camp');
        Route::get('khotbah/{slug}', 'khotbahShow')->name('khotbah.show');
    });

    // Sajikan file media (gambar konten/banner) — publik, tanpa auth.
    Route::get('media/{media}/{path}', MediaFileController::class)
        ->where('path', '.*')
        ->name('media.file');
});
