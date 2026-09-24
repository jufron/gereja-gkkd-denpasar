<?php

use App\Http\Controllers\ActivityLogController;
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

Route::view('test', 'dashboard.index')
    ->name('test');

Route::view('table', 'dashboard.table')
    ->name('table');

Route::view('dashboard', 'dashboard.index')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'dashboard.profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('profile/keamanan', fn () => view('dashboard.security', [
    // TODO: ganti array dummy ini dengan query ke tabel sessions + parse user_agent.
    'devices' => [
        ['browser' => 'Chrome', 'os' => 'Windows', 'type' => 'desktop', 'ip' => '192.168.1.1', 'location' => 'Denpasar, Bali', 'last_active' => 'Saat ini', 'current' => true],
        ['browser' => 'Safari', 'os' => 'iPhone', 'type' => 'mobile', 'ip' => '192.168.1.2', 'location' => 'Denpasar, Bali', 'last_active' => '2 jam lalu', 'current' => false],
    ],
]))->middleware(['auth'])->name('profile.security');

Route::view('pengaturan', 'dashboard.pengaturan')
    ->middleware(['auth'])
    ->name('pengaturan');

Route::get('log-aktivitas', [ActivityLogController::class, 'index'])
    ->middleware(['auth'])
    ->name('log-aktivitas');

require __DIR__.'/auth.php';
