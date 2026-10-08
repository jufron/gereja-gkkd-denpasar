<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Semua route untuk area dashboard/backend. Halaman di dalam grup "auth"
| hanya bisa diakses setelah login.
|
*/

// Scaffold / demo — belum diproteksi auth (bisa dihapus kapan saja).
Route::prefix('dashboard')->group( function () {
    Route::view('/', 'dashboard.index')->middleware('verified')->name('dashboard');
    Route::view('profile', 'dashboard.profile')->name('profile');
    Route::get('profile/keamanan', fn () => view('dashboard.security', [
        // TODO: ganti array dummy ini dengan query ke tabel sessions + parse user_agent.
        'devices' => [
            ['browser' => 'Chrome', 'os' => 'Windows', 'type' => 'desktop', 'ip' => '192.168.1.1', 'location' => 'Denpasar, Bali', 'last_active' => 'Saat ini', 'current' => true],
            ['browser' => 'Safari', 'os' => 'iPhone', 'type' => 'mobile', 'ip' => '192.168.1.2', 'location' => 'Denpasar, Bali', 'last_active' => '2 jam lalu', 'current' => false],
        ],
    ]))->name('profile.security');

    Route::view('pengaturan', 'dashboard.pengaturan')->name('dashboard.pengaturan');
    Route::get('log-aktivitas', [ActivityLogController::class, 'index'])->name('dashboard.log-aktivitas');
    Route::view('hak-akses', 'dashboard.hak-akses')->middleware('role:Administrator')->name('dashboard.hak-akses');

    // todo jadwal pelayanan & ibadah
    Route::view('jadwal-pelayanan-dan-ibadah', 'dashboard.jadwal')->middleware('permission:Kelola Jadwal')->name('dashboard.jadwal-ibadah-dan-pelayanan');
    // todo all user
    Route::get('all-user', [UserController::class, 'index'])->middleware('role:Administrator')->name('dashboard.all-user');
});