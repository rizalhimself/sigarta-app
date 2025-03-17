<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    // bikin index dulu untuk menampilkan abstrak dari halaman keluarga
    public function index()
    {
        return view('kependudukan.data-keluarga');
    }
}
