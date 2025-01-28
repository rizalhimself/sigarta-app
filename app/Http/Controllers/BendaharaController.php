<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BendaharaController extends Controller
{
    // tampilkan dashboard bendahara
    public function dashboard()
    {
        return view('/dashboard');
    }
}
