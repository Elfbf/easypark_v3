<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ScanPlatController;




/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/scan-plat', [ScanPlatController::class, 'terima']);
// Face photo untuk Python — public tapi pakai token fixed
Route::get('/face-photo/{userId}', [ScanPlatController::class, 'getFacePhoto']);
Route::post('/scan-plat', [ScanPlatController::class, 'terima']);
Route::get('/face-photo/{userId}', [ScanPlatController::class, 'getFacePhoto']);

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
    Route::get('/profile', [ProfileController::class, 'me']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/face', [ProfileController::class, 'updateFace']);

    /*
    |--------------------------------------------------------------------------
    | Vehicle References
    |--------------------------------------------------------------------------
    */
    Route::get('/vehicle-types', [VehicleController::class, 'types']);
    Route::get('/vehicle-brands/by-type/{typeId}', [VehicleController::class, 'brandsByType']);
    Route::get('/vehicle-models/by-brand/{brandId}', [VehicleController::class, 'modelsByBrand']);
    Route::post('/vehicle-models', [VehicleController::class, 'storeModel']);

    /*
    |--------------------------------------------------------------------------
    | Vehicles
    |--------------------------------------------------------------------------
    */
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::post('/vehicles/{vehicle}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);

});
