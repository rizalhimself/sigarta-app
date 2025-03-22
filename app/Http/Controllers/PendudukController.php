<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PendudukController extends Controller
{
    // Menampilkan data penduduk
    public function index()
    {
        return view('kependudukan.data-penduduk');
    }

    // Menampilkan detail penduduk
    public function show($id)
    {
        $warga = Warga::with(['penghuniRumah.rumah', 'user'])->findOrFail($id);

        // Pastikan 'umur' dihitung secara otomatis
        $warga->umur = \Carbon\Carbon::parse($warga->tgl_lahir)->age;

        Log::info("🔍 Data yang dikirim ke frontend:", $warga->toArray());
        return response()->json($warga);
    }


    // Menyimpan data penduduk baru beserta akun user
    public function store(Request $request)
    {
        try {
            $request->validate([
                // Validasi User
                'username' => 'required|string|unique:users,username|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:warga,ketua,kadus,sekertaris,bendahara1,bendahara2,humas,kerohanian,pembantuUmum',

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
            Warga::create([
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

            return response()->json(['success' => true, 'message' => 'Data penduduk berhasil ditambahkan']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("❌ Validasi Gagal: ", $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menghapus data penduduk
    public function destroy($id) {
        try {
            $warga = Warga::findOrFail($id);
            $user = User::findOrFail($warga->user_id);

            // Hapus foto profil & KTP
            if ($warga->link_foto && Storage::disk('public')->exists($warga->link_foto)) {
                Storage::disk('public')->delete($warga->link_foto);
            }

            if ($warga->link_foto_ktp && Storage::disk('public')->exists($warga->link_foto_ktp)) {
                Storage::disk('public')->delete($warga->link_foto_ktp);
            }

            // Hapus user & warga
            $user->delete();
            $warga->delete();

            return response()->json(['success' => true, 'message' => 'Data penduduk berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mengupdate data penduduk
    public function update(Request $request, Warga $warga)
    {
        Log::info("Request Data: ", $request->all());
        Log::info("Updating Warga - User ID: {$request->user_id}, Warga ID: {$request->id}");
        Log::info("Validasi UPDATE: user_id = " . ($request->user_id ?? 'NULL') . ", warga_id = " . ($request->id ?? 'NULL')); // Debugging

        try {
            $request->validate([
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore($request->user_id),
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($request->user_id),
                ],
                'password' => 'nullable|min:6',
                'role' => 'required|in:admin,warga,ketua,kadus,sekertaris,bendahara1,bendahara2,humas,kerohanian,pembantuUmum',
                'nik' => [
                    'required',
                    'string',
                    'size:16',
                    Rule::unique('warga', 'nik')->ignore($request->id),
                ],
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

            // **1. Update data user**
            Log::info("🔍 Mencari Warga dengan ID: " . ($request->id ?? 'NULL'));
            Log::info("🔍 Mencari User dengan ID: " . ($request->user_id ?? 'NULL'));

            $warga = Warga::findOrFail($request->id);
            $user = User::findOrFail($warga->user_id);
            Log::info("🔍 Username sebelum update: " . $user->username);
            $user->update([
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
            ]);
            Log::info("✅ Username setelah update: " . User::find($request->user_id)->username);

            // **Update password hanya jika diisi**
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // **2. Update data warga (kecuali foto)**
            $warga->update($request->except(['link_foto', 'link_foto_ktp']));

            // **3. Upload Foto Profil & Foto KTP jika ada file baru**
            if ($request->hasFile('link_foto')) {
                $warga->link_foto = $this->uploadFile($request, 'link_foto', 'avatars', $warga->link_foto);
            }

            if ($request->hasFile('link_foto_ktp')) {
                $warga->link_foto_ktp = $this->uploadFile($request, 'link_foto_ktp', 'ktp', $warga->link_foto_ktp);
            }

            $warga->save();

            return response()->json(['success' => true, 'message' => 'Data penduduk & user berhasil diubah']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("❌ Validasi Gagal: ", $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
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

            $query = Warga::with(['penghuniRumah.rumah', 'user']);

            if ($request->has('q') && !empty($request->q)) {
                $search = $request->input('q');
                 \Log::info("🔎 Search Query: ", ['query' => $search]); // Logging Debug

            $query
                ->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->orWhere('no_telfon', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // paginate dengan limit 5 data per halaman
            $warga = $query->paginate(5);

            // ✅ Tambahkan umur secara manual ke setiap objek warga
            $warga->each(function ($w) {
                $w->umur = \Carbon\Carbon::parse($w->tgl_lahir)->age;
                return $w;
            });

            return response()->json($warga, 200);

        } catch (\Exception $e) {
            \Log::error("❌ Search Error: " . $e->getMessage()); // Debugging Error
            return response()->json(['error' => 'Terjadi kesalahan saat pencarian'], 500);
        }
    }
}