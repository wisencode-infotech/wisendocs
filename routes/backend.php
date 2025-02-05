<?php

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth::routes();
Auth::routes(['register' => false]);

Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('change-password', [UserController::class, 'changePasswordAdmin'])->name('changepassword');
    Route::post('update-password', [UserController::class, 'updatePasswordAdmin'])->name('updatepassword');

    Route::get('/', [HomeController::class, 'root'])->name('home');
});


