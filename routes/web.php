<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\TopupPulsaController;
use App\Http\Controllers\TopUpGameController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route yang butuh login
Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/saldo', [HomeController::class, 'cekSaldo'])->name('cek.saldo');

    // Transfer
    Route::get('/transfer', [TransferController::class, 'index'])->name('transfer.index');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('/riwayat', [TransferController::class, 'riwayat'])->name('transfer.riwayat');
    Route::get('/riwayat/cetak-pdf', [TransferController::class, 'cetakPdf'])->name('riwayat.cetak-pdf');
    Route::post('/riwayat/cetak-pdf-filter', [TransferController::class, 'cetakPdfFilter'])->name('riwayat.cetak-pdf-filter');

    // Top-Up Pulsa
    Route::get('/topup', [TopupPulsaController::class, 'form'])->name('topup.form');
    Route::post('/topup', [TopupPulsaController::class, 'submit'])->name('topup.submit');
    Route::get('/topup/riwayat', [TopupPulsaController::class, 'riwayat'])->name('topup.riwayat');

    // Top-Up Game
    Route::get('/topup-game', [TopUpGameController::class, 'index'])->name('topup.index'); // <- route name dipakai di home.blade.php
    Route::post('/topup-game', [TopUpGameController::class, 'store'])->name('topup.store');
    Route::get('/topup-game/riwayat', [TopUpGameController::class, 'riwayat'])->name('topupgame.riwayat');
    Route::get('/topup-game/form', [TopUpGameController::class, 'form'])->name('topupgame.form'); // optional

    // Penarikan
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])->name('withdrawal.store');
    Route::get('/withdrawal/success/{id}', [WithdrawalController::class, 'success'])->name('withdrawal.success');
    Route::get('/withdrawal/riwayat', [WithdrawalController::class, 'riwayat'])->name('withdrawal.riwayat');
    Route::get('/withdrawal/form', [WithdrawalController::class, 'form'])->name('withdrawal.form');
    Route::patch('/withdrawal/status/{id}', [WithdrawalController::class, 'updateStatus'])->name('withdrawal.update-status');
    Route::get('/withdrawal/riwayat/cetak-pdf', [WithdrawalController::class, 'cetakPdf'])->name('withdrawal.cetak-pdf');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
