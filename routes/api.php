<?php

use App\Http\Controllers\KeluargaController;
use Illuminate\Support\Facades\Route;

Route::post('/data-keluarga/store', [KeluargaController::class, 'store']);
Route::get('/data-keluarga/search', [KeluargaController::class, 'search']);

