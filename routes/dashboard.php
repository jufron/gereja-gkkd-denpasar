<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Dashboard\BeritaController;
use App\Http\Controllers\Dashboard\KhotbahController;
use App\Http\Controllers\Dashboard\MediaLibraryController;
use App\Http\Controllers\Dashboard\NewsImageController;
use App\Http\Controllers\Dashboard\PrayerRequestController;
use App\Http\Controllers\Dashboard\SermonEvaluationController;
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

        Route::view('banner-beranda', 'dashboard.banner')
            ->middleware('permission:Kelola Beranda')
            ->name('banner-beranda');

        // todo jadwal pelayanan & ibadah
        Route::view('jadwal-pelayanan-dan-ibadah', 'dashboard.jadwal')->middleware('permission:Kelola Jadwal')->name('jadwal-ibadah-dan-pelayanan');

        // Permohonan doa — hanya Administrator.
        Route::controller(PrayerRequestController::class)->prefix('doa')->name('doa.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{prayerRequest}', 'show')->name('show');
            Route::patch('{prayerRequest}/status', 'updateStatus')->name('status');
            Route::patch('{prayerRequest}/catatan', 'updateCatatan')->name('catatan');
            Route::delete('{prayerRequest}', 'destroy')->name('destroy');
            Route::patch('pulihkan/{prayerRequest}', 'restore')->name('pulihkan');
            Route::delete('hapus-permanen/{prayerRequest}', 'forceDelete')->name('forceDelete');
        });

        // Evaluasi khotbah bulanan — hanya Administrator.
        Route::controller(SermonEvaluationController::class)->prefix('evaluasi-khotbah')->name('evaluasi-khotbah.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{evaluation}', 'show')->name('show');
            Route::delete('{evaluation}', 'destroy')->name('destroy');
        });

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

        // Rangkuman Khotbah — Administrator + permission.
        Route::middleware('permission:Kelola Khotbah')->group(function () {
            Route::controller(KhotbahController::class)->prefix('khotbah')->name('khotbah.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('tambah', 'create')->name('tambah');
                Route::post('/', 'store')->name('simpan');
                Route::get('{sermon}/ubah', 'edit')->name('ubah');
                Route::put('{sermon}', 'update')->name('update');
                Route::delete('{sermon}', 'destroy')->name('hapus');
            });
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
