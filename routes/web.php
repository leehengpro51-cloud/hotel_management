<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Grand Horizon Hotel Management System (Laravel 13)
|--------------------------------------------------------------------------
*/

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Hotel Staff & Management Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Room Types (Parent Relational Entity)
    Route::resource('room-types', RoomTypeController::class);
    Route::resource('room_types', RoomTypeController::class); // Underscore alias

    // Rooms (Child Relational Entity with FK type_id)
    Route::resource('rooms', RoomController::class);

    // Guest Bookings & Reservations
    Route::resource('reservations', ReservationController::class);
    Route::resource('bookings', ReservationController::class); // Friendly alias

    // Staff & User Management (Add / Remove Users)
    Route::resource('users', UserController::class);
});
