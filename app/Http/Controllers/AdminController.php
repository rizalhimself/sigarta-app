<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // tampilkan dashboard ad
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
