<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PendudukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// route login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// route logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route data penduduk
Route::middleware(['auth'])->group(function () {
    Route::get('/data-penduduk', [PendudukController::class, 'index'])->name('data-penduduk.index');
    Route::post('/data-penduduk/store', [PendudukController::class, 'store'])->name('data-penduduk.store');
    Route::get('/data-penduduk/search', [PendudukController::class, 'search'])->name('data-penduduk.search');
    Route::get('/data-penduduk/{id}', [PendudukController::class, 'show'])->name('data-penduduk.show');
    Route::put('/data-penduduk/{id}', [PendudukController::class, 'update'])->name('data-penduduk.update');
    Route::delete('/data-penduduk/{id}', [PendudukController::class, 'destroy'])->name('data-penduduk.destroy');
});

require __DIR__ . '/auth.php';
