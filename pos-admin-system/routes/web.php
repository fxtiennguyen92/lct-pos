<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductAttributeSetController;
use App\Http\Controllers\ProductCategoryController;
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

    Route::resource('accounts', AccountController::class)->except('show');
    Route::put('/account/{id}/restore', [AccountController::class, 'restore'])->name('accounts.restore');

    Route::resource('projects', ProjectController::class)->except('show');
    Route::put('/project/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::get('/project/{id}/settings', [ProjectController::class, 'settings'])->name('projects.settings');

    Route::resource('projects.taxes', TaxController::class)->except('show');
    Route::put('/tax/{id}/restore', [TaxController::class, 'restore'])->name('projects.taxes.restore');
    Route::put('/project/{id}/settings/taxes', [TaxController::class, 'settings'])->name('projects.taxes.settings');

    Route::resource('projects.product-attribute-sets', ProductAttributeSetController::class)->except('show');
    Route::resource('projects.product-attribute-sets.product-attributes', ProductAttributeController::class)->except('show');
    
    Route::resource('projects.product-categories', ProductCategoryController::class)->except('show');
});