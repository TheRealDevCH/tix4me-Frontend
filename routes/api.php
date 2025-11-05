<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;

Route::get('/test-email', function () {
    try {
        \Mail::to('karnathphilipp5@gmail.com')->send(new \App\Mail\WelcomeMail('Philipp', 'http://localhost:5173'));
        return response()->json(['message' => 'E-Mail erfolgreich gesendet an karnathphilipp5@gmail.com!']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/register', [RegisterController::class, 'register']);

Route::get('/auth/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify');

Route::post('/password/email', [PasswordResetController::class, 'sendResetLink']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

Route::middleware('validate.session.token')->group(function () {
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    Route::post('/auth/email/resend', [EmailVerificationController::class, 'resend'])
        ->name('verification.resend');
    Route::get('/auth/email/verification-status', [EmailVerificationController::class, 'status'])
        ->name('verification.status');

    // User profile management
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::delete('/user/account', [UserController::class, 'deleteAccount']);

    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::get('/events/my-events', [EventController::class, 'myEvents']);
});

