<!-- resources/views/kependudukan/tambah-penduduk.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg sm:max-w-xl lg:max-w-2xl xl:max-w-3xl p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-4">Tambah Penduduk</h2>
    <form action="{{ route('data-penduduk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <!-- Nama Lengkap -->
        <div>
            <label class="block text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required autofocus>
            @error('nama_lengkap') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- NIK -->
        <div>
            <label class="block text-sm font-medium">NIK</label>
            <input type="text" name="nik" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\d{16}" title="Harus 16 digit" required>
            @error('nik') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                @error('tempat_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                @error('tgl_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block text-sm font-medium">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            @error('jenis_kelamin') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- No Telepon -->
        <div>
            <label class="block text-sm font-medium">No Telepon</label>
            <input type="text" name="no_telfon" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\d+" required>
            @error('no_telfon') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Upload Foto Profil -->
        <div>
            <label class="block text-sm font-medium">Upload Foto Profil</label>
            <input type="file" name="link_foto" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="previewImage(event, 'previewFoto')">
            <img id="previewFoto" class="mt-2 hidden w-32 h-32 rounded-lg shadow" />
        </div>

        <!-- Upload Foto KTP -->
        <div>
            <label class="block text-sm font-medium">Upload Foto KTP</label>
            <input type="file" name="link_foto_ktp" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="previewImage(event, 'previewKTP')">
            <img id="previewKTP" class="mt-2 hidden w-32 h-32 rounded-lg shadow" />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between">
            <a href="{{ route('data-penduduk.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</div>

<script>
    function previewImage(event, id) {
        let reader = new FileReader();
        reader.onload = function () {
            let output = document.getElementById(id);
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
