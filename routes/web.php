<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('tentang', 'tentang')->name('tentang');
    Route::get('berita', 'berita')->name('berita');
    Route::get('galeri', 'galeri')->name('galeri');
    Route::get('kontak', 'kontak')->name('kontak');

    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', 'kegiatanIndex')->name('index');
        Route::get('pelayanan', 'pelayanan')->name('pelayanan');
        Route::get('komsel', 'komsel')->name('komsel');
        Route::get('retret-camp', 'retretCamp')->name('retret-camp');
        Route::get('khotbah/{slug}', 'khotbahShow')->name('khotbah.show');
    });
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
