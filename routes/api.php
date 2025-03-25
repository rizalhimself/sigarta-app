<?php

use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendudukController;
use Illuminate\Support\Facades\Route;


//rute api data-penduduk
Route::get('/data-penduduk/search', [PendudukController::class, 'search']);

// rute api data-keluarga
Route::post('/data-keluarga/store', [KeluargaController::class, 'store']);
Route::get('/data-keluarga/search', [KeluargaController::class, 'search']);

