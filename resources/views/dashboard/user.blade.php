@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Dashboard Warga</h1>
        <p class="text-gray-500">Selamat datang, {{ auth()->user()->username }}!</p>
        <ul>
            <li><a href="/tagihan-saya" class="text-blue-500">Tagihan Saya</a></li>
            <li><a href="/info" class="text-blue-500">Info Penting</a></li>
        </ul>
    </div>
@endsection
