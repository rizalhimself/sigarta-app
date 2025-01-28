@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <p class="text-gray-500">Selamat datang, {{ auth()->user()->username }}!</p>
        <ul>
            <li><a href="/manage-users" class="text-blue-500">Kelola Pengguna</a></li>
            <li><a href="/manage-tagihan" class="text-blue-500">Kelola Tagihan</a></li>
        </ul>
    </div>
@endsection
