<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReservationController;

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Parkings
    Route::get('/parkings', [ParkingController::class, 'index']);
    Route::get('/parkings/{id}', [ParkingController::class, 'show']);
    
    // Routes protégées pour les administrateurs
    Route::middleware('can:admin')->group(function () {
        Route::post('/parkings', [ParkingController::class, 'store']);
        Route::put('/parkings/{id}', [ParkingController::class, 'update']);
        Route::delete('/parkings/{id}', [ParkingController::class, 'destroy']);
        
        // Statistiques des parkings
        Route::get('/parkings/stats/overview', [ParkingController::class, 'overviewStats']);
        Route::get('/parkings/stats/availability', [ParkingController::class, 'availabilityStats']);
        
        // Statistiques des réservations
        Route::get('/reservations/stats', [ReservationController::class, 'reservationStats']);
    });

    // Réservations
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
});
