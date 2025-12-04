<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\BasisPengetahuanController;
use App\Http\Controllers\Admin\HistoryController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');

// Auth Routes (Manual - karena mungkin Breeze tidak terinstall)
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    
    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    
    // Diagnosa Routes
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/diagnosa/proses', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
    Route::get('/diagnosa/riwayat', [DiagnosaController::class, 'riwayat'])->name('diagnosa.riwayat');
    Route::get('/diagnosa/riwayat/{id}', [DiagnosaController::class, 'detailRiwayat'])->name('diagnosa.detail');
    Route::get('/diagnosa/cetak/{id}', [DiagnosaController::class, 'cetakHasil'])->name('diagnosa.cetak');
    Route::get('/diagnosa/bantuan', [DiagnosaController::class, 'bantuan'])->name('diagnosa.bantuan');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // Resource Routes
    Route::resource('gejala', GejalaController::class);
    Route::resource('kerusakan', KerusakanController::class);
    Route::resource('basis-pengetahuan', BasisPengetahuanController::class);
    Route::resource('history', HistoryController::class);
    
    // Additional Routes - DIPERBAIKI
    Route::post('/gejala/{gejala}/toggle-status', [GejalaController::class, 'toggleStatus'])->name('gejala.toggle-status');
   Route::post('/basis-pengetahuan/{id}/toggle-status', [BasisPengetahuanController::class, 'toggleStatus'])
    ->name('basis-pengetahuan.toggle-status');
    Route::post('/history/bulk-delete', [HistoryController::class, 'bulkDelete'])->name('history.bulk-delete');
    Route::get('/basis-pengetahuan/get-by-kerusakan/{kerusakanId}', [BasisPengetahuanController::class, 'getByKerusakan'])->name('basis-pengetahuan.get-by-kerusakan');
    Route::get('/basis-pengetahuan/get-available-gejala/{kerusakanId}', [BasisPengetahuanController::class, 'getAvailableGejala'])->name('basis-pengetahuan.get-available-gejala');
});