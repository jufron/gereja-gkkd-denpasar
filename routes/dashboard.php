<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Dashboard\BeritaController;
use App\Http\Controllers\Dashboard\MediaLibraryController;
use App\Http\Controllers\Dashboard\NewsImageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Middleware "auth" sudah dipasang di bootstrap/app.php untuk seluruh file
| ini. DashboardController menentukan tujuan berdasarkan role:
| Administrator -> /admin, Tim Pelayanan -> /pelayanan, lainnya -> beranda.
|
*/

Route::prefix('dashboard')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('dashboard.profile');
        Route::put('/', 'update')->name('dashboard.profile.update');

        // Sekuriti akun: perangkat terhubung + akhiri sesi lain.
        Route::get('keamanan', 'security')->name('dashboard.profile.security');
        Route::delete('sesi/{token}', 'destroySession')->name('dashboard.profile.session.destroy');
    });

    // Area Administrator.
    Route::middleware('role:Administrator')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', fn () => view('dashboard.index'))->middleware('verified')->name('index');

        Route::view('pengaturan', 'dashboard.pengaturan')->name('pengaturan');
        Route::get('log-aktivitas', [ActivityLogController::class, 'index'])->name('log-aktivitas');
        Route::view('hak-akses', 'dashboard.hak-akses')->name('hak-akses');

        // todo jadwal pelayanan & ibadah
        Route::view('jadwal-pelayanan-dan-ibadah', 'dashboard.jadwal')->middleware('permission:Kelola Jadwal')->name('jadwal-ibadah-dan-pelayanan');
        // todo all user
        Route::get('all-user', [UserController::class, 'index'])->name('all-user');

        // Berita Management.
        Route::view('kategori-berita', 'dashboard.kategori-berita')->middleware('permission:Kelola Berita')->name('kategori-berita');

        // Berita Management.
        Route::middleware('permission:Kelola Berita')->group(function () {
            Route::post('berita/upload-gambar', NewsImageController::class)
                ->middleware('throttle:30,1')
                ->name('berita.upload-gambar');

            Route::get('media', [MediaLibraryController::class, 'index'])->name('media.index');
            Route::delete('media/{media}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');

            Route::controller(BeritaController::class)->group(function () {
                Route::get('berita', 'index')->name('berita');
                Route::get('berita/tambah', 'create')->name('berita.tambah');
                Route::post('berita', 'store')->name('berita.simpan');
                Route::get('berita/{news}', 'show')->name('berita.lihat');
                Route::get('berita/{news}/ubah', 'edit')->name('berita.ubah');
                Route::put('berita/{news}', 'update')->name('berita.update');
                Route::delete('berita/{news}', 'destroy')->name('berita.hapus');
            });
        });

        // Keuangan: kas masuk / kas keluar / kategori.
        Route::prefix('keuangan')->name('keuangan.')->middleware('permission:Kelola Keuangan')->group(function () {
            Route::view('kas-masuk', 'dashboard.keuangan-kas', ['tipe' => 'income'])->name('masuk');
            Route::view('kas-keluar', 'dashboard.keuangan-kas', ['tipe' => 'expense'])->name('keluar');
            Route::view('kategori', 'dashboard.keuangan-kategori')->name('kategori');
        });
    });

    // Area Tim Pelayanan.
    Route::middleware('role:Tim Pelayanan')->prefix('pelayanan')->name('pelayanan.')->group(function () {
        // ponytail: pakai view overview sementara; ganti view khusus saat konten tim pelayanan jelas.
        Route::get('/', fn () => view('dashboard.index'))->name('index');
        Route::view('jadwal-pelayanan-dan-ibadah', 'dashboard.jadwal')->name('jadwal-ibadah-dan-pelayanan');
        // Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        // Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
