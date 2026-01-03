<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController as DashboardAdminController;
use App\Http\Controllers\Karyawan\DashboardController as DashboardKaryawanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\LokasiPresensiController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\KetidakhadiranController;
use App\Http\Controllers\Admin\DataKaryawanController;
use App\Http\Controllers\Admin\JadwalAbsensiController;

// Karyawan Controllers
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Karyawan\PermohonanController as KaryawanPermohonanController;
use App\Http\Controllers\Karyawan\ProfilController;

// Import Middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KaryawanMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    if (auth()->check()) {
        // Jika sudah login, redirect berdasarkan role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('karyawan.dashboard');
        }
    }
    // Jika belum login, redirect ke login
    return redirect()->route('login');
});

// ==================== GUEST ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flush();
        return redirect()->route('login')->with('status', 'Berhasil logout!');
    })->name('logout');

    // ==================== ADMIN ROUTES ====================
    // Tambahkan middleware 'admin' di sini
    Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {

        // 1. DASHBOARD
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

        // 2. PEGAWAI MANAGEMENT - MANUAL ROUTES
        Route::prefix('pegawai')->name('pegawai.')->group(function () {
            Route::get('/', [DataKaryawanController::class, 'index'])->name('index');
            Route::get('/create', [DataKaryawanController::class, 'create'])->name('create');
            Route::post('/', [DataKaryawanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataKaryawanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataKaryawanController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataKaryawanController::class, 'destroy'])->name('destroy');
        });

        // 3. JABATAN MANAGEMENT - MANUAL ROUTES
        Route::prefix('jabatan')->name('jabatan.')->group(function () {
            Route::get('/', [JabatanController::class, 'index'])->name('index');
            Route::get('/create', [JabatanController::class, 'create'])->name('create');
            Route::post('/', [JabatanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JabatanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JabatanController::class, 'update'])->name('update');
            Route::delete('/{id}', [JabatanController::class, 'destroy'])->name('destroy');
        });

        // 4. LOKASI PRESENSI - MANUAL ROUTES
        Route::prefix('lokasi-presensi')->name('lokasi-presensi.')->group(function () {
            Route::get('/', [LokasiPresensiController::class, 'index'])->name('index');
            Route::get('/create', [LokasiPresensiController::class, 'create'])->name('create');
            Route::post('/', [LokasiPresensiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LokasiPresensiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LokasiPresensiController::class, 'update'])->name('update');
            Route::delete('/{id}', [LokasiPresensiController::class, 'destroy'])->name('destroy');
        });

        // 5. JADWAL ABSENSI - MANUAL ROUTES
        Route::prefix('jadwal-absensi')->name('jadwal-absensi.')->group(function () {
            Route::get('/', [JadwalAbsensiController::class, 'index'])->name('index');
            Route::get('/create', [JadwalAbsensiController::class, 'create'])->name('create');
            Route::post('/', [JadwalAbsensiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JadwalAbsensiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JadwalAbsensiController::class, 'update'])->name('update');
            Route::delete('/{id}', [JadwalAbsensiController::class, 'destroy'])->name('destroy');
        });

        // 6. REKAP ABSENSI - MANUAL ROUTES
        Route::prefix('rekap-absensi')->name('rekap-absensi.')->group(function () {
            Route::get('/', [RekapAbsensiController::class, 'index'])->name('index');
            Route::get('/export', [RekapAbsensiController::class, 'export'])->name('export');
            Route::get('/print', [RekapAbsensiController::class, 'print'])->name('print');
        });

        // 7. KETIDAKHADIRAN - MANUAL ROUTES
        Route::prefix('ketidakhadiran')->name('ketidakhadiran.')->group(function () {
            Route::get('/', [KetidakhadiranController::class, 'index'])->name('index');
            Route::get('/create', [KetidakhadiranController::class, 'create'])->name('create');
            Route::post('/', [KetidakhadiranController::class, 'store'])->name('store');
            Route::get('/{ketidakhadiran}/edit', [KetidakhadiranController::class, 'edit'])->name('edit');
            Route::put('/{ketidakhadiran}', [KetidakhadiranController::class, 'update'])->name('update');
            Route::delete('/{ketidakhadiran}', [KetidakhadiranController::class, 'destroy'])->name('destroy');
            Route::put('/{ketidakhadiran}/approve', [KetidakhadiranController::class, 'approve'])->name('approve');
            Route::put('/{ketidakhadiran}/reject', [KetidakhadiranController::class, 'reject'])->name('reject');
        });
    });

    // ==================== KARYAWAN ROUTES ====================
    // Tambahkan middleware 'karyawan' di sini
    Route::prefix('karyawan')->name('karyawan.')->middleware(KaryawanMiddleware::class)->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardKaryawanController::class, 'index'])->name('dashboard');

        // Absensi - MANUAL ROUTES
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/', [KaryawanAbsensiController::class, 'index'])->name('index');
            Route::post('/masuk', [KaryawanAbsensiController::class, 'masuk'])->name('masuk');
            Route::post('/pulang', [KaryawanAbsensiController::class, 'pulang'])->name('pulang');
            Route::get('/riwayat', [KaryawanAbsensiController::class, 'riwayat'])->name('riwayat');
        });

        // Permohonan - MANUAL ROUTES
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [KaryawanPermohonanController::class, 'index'])->name('index');
            Route::get('/create', [KaryawanPermohonanController::class, 'create'])->name('create');
            Route::post('/', [KaryawanPermohonanController::class, 'store'])->name('store');
            Route::get('/{id}', [KaryawanPermohonanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KaryawanPermohonanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KaryawanPermohonanController::class, 'update'])->name('update');
            Route::delete('/{id}', [KaryawanPermohonanController::class, 'destroy'])->name('destroy');
        });

        // Profil - MANUAL ROUTES
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [ProfilController::class, 'index'])->name('index');
            Route::put('/password', [ProfilController::class, 'updatePassword'])->name('password.update');
        });
    });
});
