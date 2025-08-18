<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('auth', [AuthController::class, 'authentication'])->name('auth.authentication');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return 'Admin';
        })->name('admin.dashboard');
    });
});
