<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ScanPlatController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/scan-plat', [ScanPlatController::class, 'terima']); // tambah ini
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    // Get authenticated user
    Route::get('/me', [AuthController::class, 'me']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    // Get profile
    Route::get('/profile', [ProfileController::class, 'me']);

    // Update profile
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // Update password
    Route::post('/profile/password', [
        ProfileController::class,
        'updatePassword'
    ]);

    // Update face data
    Route::post('/profile/face', [
        ProfileController::class,
        'updateFace'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Vehicles
    |--------------------------------------------------------------------------
    */

    // Get all vehicles
    Route::get('/vehicles', [VehicleController::class, 'index']);

    // Get detail vehicle
    Route::get('/vehicles/{vehicle}', [
        VehicleController::class,
        'show'
    ]);

    // Create vehicle
    Route::post('/vehicles', [
        VehicleController::class,
        'store'
    ]);

    // Update vehicle
    Route::post('/vehicles/{vehicle}', [
        VehicleController::class,
        'update'
    ]);

    // Delete vehicle
    Route::delete('/vehicles/{vehicle}', [
        VehicleController::class,
        'destroy'
    ]);

});