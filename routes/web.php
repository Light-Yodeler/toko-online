<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('loginPage')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('authentication', [AuthController::class, 'authentication'])->name('login.process');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });
});
