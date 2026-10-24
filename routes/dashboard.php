<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Dashboard\BeritaController;
use App\Http\Controllers\Dashboard\BeritaFormController;
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
    });
    Route::get('profile/keamanan', fn () => view('dashboard.security', [
        // TODO: ganti array dummy ini dengan query ke tabel sessions + parse user_agent.
        'devices' => [
            ['browser' => 'Chrome', 'os' => 'Windows', 'type' => 'desktop', 'ip' => '192.168.1.1', 'location' => 'Denpasar, Bali', 'last_active' => 'Saat ini', 'current' => true],
            ['browser' => 'Safari', 'os' => 'iPhone', 'type' => 'mobile', 'ip' => '192.168.1.2', 'location' => 'Denpasar, Bali', 'last_active' => '2 jam lalu', 'current' => false],
        ],
    ]))->name('dashboard.profile.security');

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
            Route::post('berita/upload-gambar', NewsImageController::class)->name('berita.upload-gambar');
            Route::get('berita', [BeritaController::class, 'index'])->name('berita');
            Route::get('berita/tambah', [BeritaFormController::class, 'create'])->name('berita.tambah');
            Route::post('berita', [BeritaFormController::class, 'store'])->name('berita.simpan');
            Route::get('berita/{news}/ubah', [BeritaFormController::class, 'edit'])->name('berita.ubah');
            Route::put('berita/{news}', [BeritaFormController::class, 'update'])->name('berita.update');
            Route::delete('berita/{news}', [BeritaFormController::class, 'destroy'])->name('berita.hapus');
        });
    });

    // Area Tim Pelayanan.
    Route::middleware('role:Tim Pelayanan')->prefix('pelayanan')->name('pelayanan.')->group(function () {
        // ponytail: pakai view overview sementara; ganti view khusus saat konten tim pelayanan jelas.
        Route::get('/', fn () => view('dashboard.index'))->name('index');
        Route::view('jadwal-pelayanan-dan-ibadah', 'dashboard.jadwal')->name('jadwal-ibadah-dan-pelayanan');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
