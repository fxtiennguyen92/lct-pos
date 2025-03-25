<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchSettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExternalAppointmentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectAccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpecialHourController;
use App\Http\Controllers\WorkingHourController;
use App\Models\BranchSetting;
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

// Reservation
Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');
Route::get('external/{projectCode}/{branchCode}/init', [ExternalAppointmentController::class, 'init']);
Route::get('external/{projectCode}/{branchCode}/calendar', [ExternalAppointmentController::class, 'show']);
Route::post('external/{projectCode}/{branchCode}/reserve', [ExternalAppointmentController::class, 'reserve']);



// Super Admin
Route::middleware(['auth', 'super-admin'])->group(function () {
    Route::resource('projects', ProjectController::class)->except(['destroy', 'show']);
    Route::resource('projects.branches', BranchController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('business/{projectCode}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('business/{projectCode}/branches/{branchCode}', [ProjectController::class, 'branch'])->name('projects.branches.show');

    Route::middleware('has-project')->group(function () {
        // Settings
        Route::resource('business/{projectCode}/branches/{branchCode}/settings', BranchSettingController::class)->only(['index', 'update']);

        // Working hours
        Route::get('business/{projectCode}/branches/{branchCode}/working-hours', [WorkingHourController::class, 'edit'])->name('working-hours.edit');
        Route::post('business/{projectCode}/branches/{branchCode}/working-hours', [WorkingHourController::class, 'update'])->name('working-hours.update');

        

        // Special hours
        Route::resource('business/{projectCode}/branches/{branchCode}/special-hours', SpecialHourController::class)->except(['show', 'create', 'edit', 'update']);

        // Apointments
        Route::resource('business/{projectCode}/branches/{branchCode}/appointments', AppointmentController::class)->except(['destroy']);
        
        //Route::post('business/{projectCode}/branches/{branchCode}/restaurant/reservation', [AppointmentController::class, 'book'])->name('reservation.book');

        // Accounts
        Route::resource('business/{projectCode}/project-accounts', ProjectAccountController::class)->except('destroy');

        
        // Categories
        Route::resource('business/{projectCode}/categories', CategoryController::class);
        Route::post('business/{projectCode}/categories/priority', [CategoryController::class, 'updatePriority'])->name('categories.priority');

        // Services

        Route::get('business/{projectCode}/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    });
});
