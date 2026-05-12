<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Auth;

// Dashboard Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\VehicleBrandController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Admin\ParkingAreaController;
use App\Http\Controllers\Admin\ParkingSlotController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\ParkingRecordController;

// Petugas Controllers
use App\Http\Controllers\Petugas\ParkingAreaController as PetugasParkingAreaController;
use App\Http\Controllers\Petugas\ParkingSlotController as PetugasParkingSlotController;
use App\Http\Controllers\Petugas\ParkingRecordController as PetugasParkingRecordController;
use App\Http\Controllers\Petugas\KioskController;



// Auth Controllers
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


// LANDING
// LANDING
Route::get('/', [LandingController::class, 'index']);
// LANDING
Route::prefix('user')->group(function () {
    Route::get('/', [LandingController::class, 'user']);  // ← ini yang hilang
    Route::get('/cek-slot', [LandingController::class, 'cekSlot']);
    Route::get('/info', [LandingController::class, 'info']);
    Route::get('/kiosk-status', [LandingController::class, 'kioskStatus'])->name('landing.kiosk-status');
});

// FORGOT PASSWORD OTP
Route::middleware('guest')->group(function () {

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::post('/verify-otp', [ResetPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::post('/reset-password-otp', [ResetPasswordController::class, 'resetPassword'])->name('password.reset.update');
});


// REDIRECT DASHBOARD
Route::get('/dashboard', function () {

    $user = Auth::user();

    if (! $user) {
        return redirect('/login');
    }

    return match ($user->role->name) {
        'admin'   => redirect('/admin/dashboard'),
        'petugas' => redirect('/petugas/dashboard'),
        default   => abort(403),
    };
})->middleware(['auth'])->name('dashboard');


// ADMIN
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/refresh', [AdminDashboardController::class, 'refresh']);

        Route::resource('/roles', RoleController::class);
        Route::resource('/departments', DepartmentController::class);
        Route::resource('/study-programs', StudyProgramController::class);

        Route::resource('/petugas', PetugasController::class)
            ->parameters(['petugas' => 'petugas:id']);

        Route::resource('/mahasiswa', MahasiswaController::class)
            ->parameters(['mahasiswa' => 'mahasiswa:id']);

        Route::resource('/vehicle-types', VehicleTypeController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/vehicle-brands', VehicleBrandController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/vehicle-models', VehicleModelController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/parking-areas', ParkingAreaController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/parking-slots', ParkingSlotController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/vehicles', VehicleController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('/parking-records', ParkingRecordController::class)
            ->only(['index']);

        Route::get(
            '/parking-records/print',
            [ParkingRecordController::class, 'printReport']
        )->name('parking-records.print');
    });

// PETUGAS
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');

        // Kiosk
        Route::get('/kiosk', [KioskController::class, 'index'])
            ->name('kiosk');
        Route::post('/kiosk/scan-plat', [KioskController::class, 'scanPlat']);
        Route::get('/kiosk/cek-plat', [KioskController::class, 'cekPlat']);
        Route::post('/kiosk/konfirmasi-keluar', [KioskController::class, 'konfirmasiKeluar']);
        Route::post('/kiosk/konfirmasi-masuk', [KioskController::class, 'konfirmasiMasuk'])
    ->name('petugas.kiosk.konfirmasiMasuk');
            

        Route::resource('/parking-areas', PetugasParkingAreaController::class)
            ->only(['index']);

        Route::resource('/parking-slots', PetugasParkingSlotController::class)
            ->only(['index']);

        // Parking Records
        Route::get('/parking-records', [PetugasParkingRecordController::class, 'index'])
            ->name('parking-records.index');
        Route::post('/parking-records/entry', [PetugasParkingRecordController::class, 'entry'])
            ->name('parking-records.entry');
        Route::post('/parking-records/exit', [PetugasParkingRecordController::class, 'exit'])
            ->name('parking-records.exit');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile',            [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
});

// AUTH
require __DIR__ . '/auth.php';