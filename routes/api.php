<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::put('/bookings/{booking}/accept', [BookingController::class, 'accept']);
    Route::put('/bookings/{booking}/complete', [BookingController::class, 'complete']);

    Route::get('/user/{user}', [ProfileController::class, 'show']);
    Route::get('/profile', [ProfileController::class, 'myProfile']);

    Route::put('/bookings/{booking}/accept', [BookingController::class, 'accept']);
    Route::put('/bookings/{booking}/complete', [BookingController::class, 'complete']);
    Route::post('/bookings', [BookingController::class, 'store']);

    Route::get('/ratings/{rider}', [RatingController::class, 'show']);
    Route::post('/ratings', [RatingController::class, 'store']);

});
