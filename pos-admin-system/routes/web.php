<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaxController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('accounts', AccountController::class);
    Route::put('/account/{id}/restore', [AccountController::class, 'restore'])->name('accounts.restore');

    Route::resource('projects', ProjectController::class);
    Route::put('/project/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');

    Route::resource('projects.taxes', TaxController::class);
    Route::put('/project/{projectId}/taxes/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
});