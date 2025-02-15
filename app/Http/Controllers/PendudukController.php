<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    // Menampilkan data penduduk
    public function index(Request $request)
    {
        $query = Warga::with(['keluarga', 'user']);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_telfon', 'like', "%{$search}%");
            })->orWhereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $warga = $query->paginate(10);
        return view('kependudukan.data-penduduk', compact('warga'));
    }

    // Menampilkan detail penduduk
    public function show($id)
    {
        $warga = Warga::with(['keluarga', 'user'])->findOrFail($id);
        return response()->json($warga);
    }

    // Menampilkan form tambah penduduk
    public function create()
    {
        return view('kependudukan.tambah-penduduk');
    }

    // Menyimpan data penduduk baru beserta akun user
    public function store(Request $request)
    {
        $request->validate([
            // Validasi User
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:warga,ketua,sekertaris,bendahara1,bendahara2,humas1,humas2,kerohanian1,kerohanian2,pembantuUmum1,pembantuUmum2',

            // Validasi Warga
            'nik' => 'required|string|size:16|unique:warga,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan_darah' => 'nullable',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_perkawinan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'no_telfon' => 'required|string|max:15',
            'link_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan User
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Simpan Warga
        $warga = Warga::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'golongan_darah' => $request->golongan_darah,
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'pekerjaan' => $request->pekerjaan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_telfon' => $request->no_telfon,
            'link_foto' => $this->uploadFile($request, 'link_foto', 'avatars'),
            'link_foto_ktp' => $this->uploadFile($request, 'link_foto_ktp', 'ktp'),
        ]);

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan');
    }

    // Menampilkan form edit data penduduk
    public function edit(Warga $warga)
    {
        return view('kependudukan.edit-penduduk', compact('warga'));
    }

    // Mengupdate data penduduk
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:warga,nik,' . $warga->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan_darah' => 'nullable',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_perkawinan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'no_telfon' => 'required|string|max:15',
            'link_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $warga->update($request->except(['link_foto', 'link_foto_ktp']));
        $warga->link_foto = $this->uploadFile($request, 'link_foto', 'avatars', $warga->link_foto);
        $warga->link_foto_ktp = $this->uploadFile($request, 'link_foto_ktp', 'ktp', $warga->link_foto_ktp);
        $warga->save();

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil diubah');
    }

    // Menghapus data penduduk
    public function destroy(Warga $warga)
    {
        if ($warga->keluarga) {
            $warga->keluarga->delete();
        }

        if ($warga->user) {
            $warga->user->delete();
        }

        Storage::disk('public')->delete([$warga->link_foto, $warga->link_foto_ktp]);
        $warga->delete();

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil dihapus');
    }

    // Fungsi untuk upload file
    private function uploadFile(Request $request, $inputName, $path, $oldFile = null)
    {
        if ($request->hasFile($inputName)) {
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
            return $request->file($inputName)->store($path, 'public');
        }
        return $oldFile;
    }

    // Fungsi search dengan ajax
    public function search(Request $request)
    {
        try {
            if (!$request->has('q')) {
                return response()->json(['error' => 'Parameter q diperlukan'], 400);
            }

            $search = $request->input('q');

            \Log::info("🔎 Search Query: ", ['query' => $search]); // Logging Debug

            $warga = Warga::with(['keluarga', 'user'])
                ->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->orWhere('no_telfon', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->get();

            return response()->json($warga, 200);

        } catch (\Exception $e) {
            \Log::error("❌ Search Error: " . $e->getMessage()); // Debugging Error
            return response()->json(['error' => 'Terjadi kesalahan saat pencarian'], 500);
        }
    }
}

