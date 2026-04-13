<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SentimentController;
use App\Http\Controllers\Admin\TimController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramUserController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\DetailController;

use App\Http\Controllers\Auth\AuthController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/program', [ProgramUserController::class, 'index']);
Route::get('/ulasan', [UlasanController::class, 'index']);
Route::post('/ulasan/store', [UlasanController::class, 'store'])->name('ulasan.store');
Route::view('/kontak', 'kontak');
Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail.index');
Route::get('/tentang', function () {return view('tentang');});

// Auth Routes
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('beritas', ProgramController::class);
    Route::resource('tim', TimController::class);
    
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::post('/monitoring/jadwal', [MonitoringController::class, 'storeJadwal']);
    Route::put('/monitoring/jadwal/{id}', [MonitoringController::class, 'updateJadwal']);
    Route::delete('/monitoring/jadwal/{id}', [MonitoringController::class, 'destroyJadwal']);

    Route::get('/sentiment', [SentimentController::class, 'index'])->name('sentiment.index');
    Route::post('/sentiment/process', [SentimentController::class, 'process'])->name('sentiment.process');
});