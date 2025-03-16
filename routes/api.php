<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReservationController;

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // Réservations
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

    // Routes protégées pour les administrateurs
    Route::middleware('Admin')->group(function () {

        Route::get('/regions', [RegionController::class, 'index']);
        Route::get('/regions/{id}', [RegionController::class, 'show']);
        Route::post('/regions', [RegionController::class, 'store']);
        Route::put('/regions/{region}', [RegionController::class, 'update']);
        Route::delete('/regions/{id}', [RegionController::class, 'destroy']);


        Route::get('/parkings', [ParkingController::class, 'index']);
        Route::get('/parkings/{id}', [ParkingController::class, 'show']);
        Route::post('/parkings', [ParkingController::class, 'store']);
        Route::put('/parkings/{id}', [ParkingController::class, 'update']);
        Route::delete('/parkings/{id}', [ParkingController::class, 'destroy']);


        Route::get('/positions', [PositionController::class, 'index']);
        Route::get('/positions/{id}', [PositionController::class, 'show']);
        Route::post('/positions', [PositionController::class, 'store']);
        Route::put('/positions/{id}', [PositionController::class, 'update']);
        Route::delete('/positions/{id}', [PositionController::class, 'destroy']);
    });
});












Route::get('/parkings/stats/overview', [ParkingController::class, 'overviewStats']);
Route::get('/parkings/stats/availability', [ParkingController::class, 'availabilityStats']);


Route::get('/reservations/stats', [ReservationController::class, 'reservationStats']);