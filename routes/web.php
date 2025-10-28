<?php

use Illuminate\Support\Facades\Route;

// Password Reset Route (required by Laravel's password reset notification)
Route::get('/reset-password/{token}', function ($token) {
    return view('app');
})->name('password.reset'); // Required by Laravel's password reset notification

// Catch-all route for SPA (must be last)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*')->name('spa');

