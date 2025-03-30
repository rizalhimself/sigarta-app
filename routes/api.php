<?php

use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendudukController;
use Illuminate\Support\Facades\Route;


//rute api data-penduduk
Route::get('/data-penduduk/search', [PendudukController::class, 'search']);

// rute api data-keluarga
Route::post('/data-keluarga/store-keluarga', [KeluargaController::class, 'storeKeluarga']);
Route::post('/data-keluarga/store-anggota-keluarga', [KeluargaController::class, 'storeAnggotaKeluarga']);
Route::get('/data-keluarga/search', [KeluargaController::class, 'search']);

