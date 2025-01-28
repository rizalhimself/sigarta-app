<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // tampilkan dashboard berdasarkan role

    public function index()
    {
        $role = auth()->user()->role;

        if ($role == 'admin') {
            return view('dashboard.admin');         // view dashboard untuk admin
        } elseif ($role == 'bendahara') {
            return view('dashboard.bendahara');     // view dashboard untuk bendahara
        }

        // view default untuk warga
        return view('dashboard.user');
    }
}
