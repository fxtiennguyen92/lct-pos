<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectAccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpecialHourController;
use App\Http\Controllers\WorkingHourController;
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
    Route::resource('projects', ProjectController::class)->except(['destroy', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('business/{projectCode}/dashboard', [ProjectController::class, 'show'])->name('projects.show');

    Route::middleware('has-project')->group(function () {
        Route::resource('business/{projectCode}/project-accounts', ProjectAccountController::class)->except('destroy');

        Route::get('business/{projectCode}/working-hours', [WorkingHourController::class, 'edit'])->name('working-hours.edit');
        Route::post('business/{projectCode}/working-hours', [WorkingHourController::class, 'update'])->name('working-hours.update');
    
        Route::resource('business/{projectCode}/special-hours', SpecialHourController::class)->except('show');
    });
});
