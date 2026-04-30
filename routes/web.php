<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;

// Dashboard Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\VehicleBrandController;
use App\Http\Controllers\Admin\ParkingAreaController;
use App\Http\Controllers\Admin\ParkingSlotController;
use App\Http\Controllers\Admin\VehicleController;

// Auth Controllers
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


// LANDING
Route::get('/', [LandingController::class, 'index']);


// 🔥 FORGOT PASSWORD OTP
Route::middleware('guest')->group(function () {

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.email');

    Route::post('/verify-otp', [ResetPasswordController::class, 'verifyOtp'])
        ->name('password.otp.verify');

    Route::post('/reset-password-otp', [ResetPasswordController::class, 'resetPassword'])
        ->name('password.reset.update');
});


// 🔥 REDIRECT DASHBOARD
Route::get('/dashboard', function () {

    $user = auth()->user();

    if (! $user) {
        return redirect('/login');
    }

    return match ($user->role->name) {

        'admin'     => redirect('/admin/dashboard'),
        'petugas'   => redirect('/petugas/dashboard'),
        'mahasiswa' => redirect('/mahasiswa/dashboard'),

        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');


// 🔥 ADMIN
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ROLE
        Route::resource('/roles', RoleController::class);

        // JURUSAN
        Route::resource('/departments', DepartmentController::class);

        // PROGRAM STUDI
        Route::resource('/study-programs', StudyProgramController::class);

        // PETUGAS
        Route::resource('/petugas', PetugasController::class)
            ->parameters(['petugas' => 'petugas:id']);

        // MAHASISWA
        Route::resource('/mahasiswa', MahasiswaController::class)
            ->parameters(['mahasiswa' => 'mahasiswa:id']);

        // 🔥 TIPE KENDARAAN
        Route::resource('/vehicle-types', VehicleTypeController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // 🔥 BRAND KENDARAAN
        Route::resource('/vehicle-brands', VehicleBrandController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // 🔥 AREA PARKIR
        Route::resource('/parking-areas', ParkingAreaController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // 🔥 SLOT PARKIR
        Route::resource('/parking-slots', ParkingSlotController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // 🔥 KENDARAAN
        Route::resource('/vehicles', VehicleController::class);
    });


// 🔥 PETUGAS
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');
    });


// 🔥 MAHASISWA
Route::prefix('mahasiswa')
    ->middleware(['auth', 'role:mahasiswa'])
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
            ->name('dashboard');
    });


// 🔥 TEST 401
Route::get('/test401', function () {
    abort(401);
});


// 🔥 TEST 405
Route::post('/test405', function () {
    return 'OK';
});


// 🔥 TEST 419
Route::post('/test419', function () {
    return 'OK';
});

Route::get('/form419', function () {

    return '
        <form method="POST" action="/test419">
            <button type="submit">
                Submit
            </button>
        </form>
    ';
});


// 🔥 TEST 422
Route::post('/test422', function (\Illuminate\Http\Request $request) {

    $request->validate([
        'name' => 'required',
    ]);

    return 'OK';
});

Route::get('/form422', function () {

    return '
        <form method="POST" action="/test422">

            ' . csrf_field() . '

            <button type="submit">
                Submit
            </button>

        </form>
    ';
});


// 🔥 TEST 429
Route::middleware('throttle:1,1')->get('/test429', function () {
    return 'OK';
});


// 🔥 TEST 500
Route::get('/test500', function () {
    abort(500);
});


// PROFILE
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// AUTH
require __DIR__ . '/auth.php';
