<div class="text-center py-4">
    {{--Tulisan Sugeng Rawuh Melengkung--}}
    {{--<h2 class="curved-text text-gray-900 dark:text-white">Sugeng Rawuh</h2>--}}

    {{--Gambar Aksara Jawa--}}
    {{--<img src="{{ asset('img/Sugeng_Rawuh_-_Javanese_Script.png') }}" alt="Sugeng Rawuh Aksara Jawa"
    class="mx-auto w-32 h-auto mt-2">--}}

    {{--Greeting Berdasarkan Waktu--}}
    <p id="greeting" class="mt-2 text-gray-700 dark:text-gray-300 text-lg font-medium"
       data-username="{{ auth()->user()->warga->nama_lengkap ?? 'Guest' }}"></p>
</div>
