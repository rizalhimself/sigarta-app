@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Dashboard Bendahara</h1>
        <p class="text-gray-500">Selamat datang, {{ auth()->user()->username }}!</p>
        <ul>
            <li><a href="/laporan-keuangan" class="text-blue-500">Laporan Keuangan</a></li>
            <li><a href="/transaksi" class="text-blue-500">Kelola Transaksi</a></li>
        </ul>
    </div>
@endsection
