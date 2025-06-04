<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Home page setelah login
Route::get('/home', function () {
    return view('home');
})->name('home');


