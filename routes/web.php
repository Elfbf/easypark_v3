<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Dashboard Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudyProgramController;


// LANDING
Route::get('/', function () {
    return view('landing.index');
});


// 🔥 REDIRECT DASHBOARD
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect('/login');
    }

    return match ($user->role->name) {
        'admin' => redirect('/admin/dashboard'),
        'petugas' => redirect('/petugas/dashboard'),
        'mahasiswa' => redirect('/mahasiswa/dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');


// 🔥 ADMIN
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ROLE
        Route::resource('/roles', RoleController::class);

        // JURUSAN
        Route::resource('/departments', DepartmentController::class);

        // PROGRAM STUDI
        Route::resource('/study-programs', StudyProgramController::class);
    });


// 🔥 PETUGAS
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('petugas.dashboard');
});


// 🔥 MAHASISWA
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');
});


// 🔥 TEST 419
Route::post('/test419', function () {
    return 'OK';
});

Route::get('/form419', function () {
    return '
        <form method="POST" action="/test419">
            <button type="submit">Submit</button>
        </form>
    ';
});


// 🔥 TEST 429
Route::middleware('throttle:1,1')->get('/test429', function () {
    return 'OK';
});


// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// AUTH
require __DIR__ . '/auth.php';