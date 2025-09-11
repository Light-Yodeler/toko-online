<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kasir\DashboardController as KasirController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPhotoController;
use Illuminate\Support\Facades\Route;

Route::middleware('loginPage')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('authentication', [AuthController::class, 'authentication'])->name('login.process');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('role:admin')->group(function () {
        Route::get('/user/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::get('/user/data', [UserController::class, 'dataUser'])->name('admin.user.data');
        Route::get('/user/data/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::get('/user/data/add', [UserController::class, 'addUser'])->name('admin.user.add');
        Route::post('/user/data/create', [UserController::class, 'createUser'])->name('admin.user.create');
        Route::post('/user/data/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/data/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
        Route::get('/user/admin/{user}/photo', [UserPhotoController::class, 'show'])->name('admin.user.photo');
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:kasir')->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
        Route::get('/user/kasir/{user}/photo', [UserPhotoController::class, 'show'])->name('kasir.photo');
    });
});
