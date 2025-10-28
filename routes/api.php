<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;

/**
 * ============================================================================
 * PUBLIC ROUTES (No Authentication Required)
 * ============================================================================
 */

// Authentication Routes
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

// Public Event Routes
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

/**
 * ============================================================================
 * PROTECTED ROUTES (Authentication Required)
 * ============================================================================
 */

Route::middleware('validate.session.token')->group(function () {
    // Authentication Routes
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    // Protected Event Routes
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::get('/events/my-events', [EventController::class, 'myEvents']);
});

