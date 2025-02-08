<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/reservation', function () {
    return view('calendar.reservation');
});


// Authentication
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::get('/reset-password', [AuthController::class, 'viewResetPassword'])->name('password.view');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Locale
Route::get('/change-locale/{locale}', [LanguageController::class, 'change'])->name('change.locale');

// Super Admin
Route::middleware(['auth', 'super-admin'])->group(function () {
    Route::resource('projects', ProjectController::class);
});