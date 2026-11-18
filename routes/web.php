<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // <-- 1. Tambahkan baris import ini di bagian atas

// 2. Tambahkan baris route di bawah ini
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');