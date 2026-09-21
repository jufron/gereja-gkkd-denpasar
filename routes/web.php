<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('welcome');

Route::controller(PagesController::class)->group( function () {
    Route::get('home', 'index')->name('home');
    Route::get('tentang', 'tentang')->name('tentang');
});


Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
    Route::get('/', function () {
        return view('kegiatan.index');
    })->name('index');

    Route::get('/ibadah-raya', function () {
        return view('kegiatan.ibadah-raya');
    })->name('ibadah-raya');

    Route::get('/doa-bersama', function () {
        return view('kegiatan.doa-bersama');
    })->name('doa-bersama');

    Route::get('/sekolah-minggu', function () {
        return view('kegiatan.sekolah-minggu');
    })->name('sekolah-minggu');

    Route::get('/persekutuan-wilayah', function () {
        return view('kegiatan.persekutuan-wilayah');
    })->name('persekutuan-wilayah');
    Route::get('/khotbah/{slug}', function ($slug) {
        return view('kegiatan.khotbah-detail', ['slug' => $slug]);
    })->name('khotbah.show');
});

Route::get('/berita', function () {
    return view('berita');
})->name('berita');

Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');
