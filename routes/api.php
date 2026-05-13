<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ScanPlatController;
use App\Http\Controllers\Api\ParkingRecordController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/login', [AuthController::class, 'login']);

// Scan Plat & Face Recognition
Route::post('/scan-plat', [ScanPlatController::class, 'terima']);

Route::get('/face-photo/{userId}', [ScanPlatController::class, 'getFacePhoto']);

Route::post('/face-result', [ScanPlatController::class, 'terimaFace']);

Route::get('/face-check', [ScanPlatController::class, 'cekFace']);

Route::post('/face-reset', [ScanPlatController::class, 'resetFace']);


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

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->group(function () {

        Route::get('/', [ProfileController::class, 'me']);

        Route::post('/update', [ProfileController::class, 'update']);

        Route::post('/password', [ProfileController::class, 'updatePassword']);

        Route::post('/face', [ProfileController::class, 'updateFace']);
    });


    /*
    |--------------------------------------------------------------------------
    | Vehicle References
    |--------------------------------------------------------------------------
    */

    Route::prefix('vehicle-references')->group(function () {

        Route::get('/types', [VehicleController::class, 'types']);

        Route::get('/brands/by-type/{typeId}', [
            VehicleController::class,
            'brandsByType'
        ]);

        Route::get('/models/by-brand/{brandId}', [
            VehicleController::class,
            'modelsByBrand'
        ]);

        Route::post('/models', [
            VehicleController::class,
            'storeModel'
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Vehicles
    |--------------------------------------------------------------------------
    */

    Route::prefix('vehicles')->group(function () {

        Route::get('/', [VehicleController::class, 'index']);

        Route::get('/{vehicle}', [VehicleController::class, 'show']);

        Route::post('/', [VehicleController::class, 'store']);

        Route::post('/{vehicle}', [VehicleController::class, 'update']);

        Route::delete('/{vehicle}', [VehicleController::class, 'destroy']);
    });


    /*
    |--------------------------------------------------------------------------
    | Parking Records
    |--------------------------------------------------------------------------
    */

    Route::prefix('parking-records')->group(function () {

        Route::get('/history', [
            ParkingRecordController::class,
            'history'
        ]);

        Route::get('/last-status', [
            ParkingRecordController::class,
            'lastStatus'
        ]);

        Route::get('/last-entry-exit', [
            ParkingRecordController::class,
            'lastEntryExit'
        ]);
    });
});