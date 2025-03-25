<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keluarga;
use App\Models\AnggotaKeluarga;
use Storage;

class KeluargaController extends Controller
{
    // bikin index dulu untuk menampilkan abstrak dari halaman keluarga
    public function index()
    {
        return view('kependudukan.data-keluarga');
    }

    public function store(Request $request)
    {
        try {
            // validasi keluarga
            $request->validate([
                // validasi data keluarga
                'no_kk' => 'required|string|size:16|unique:keluarga,no_kk',
                'kepala_keluarga_id' => 'required|exists:warga,id',
                'link_foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

                // validasi data anggota_keluarga
                'warga_id' => 'required|exists:warga,id',
                'status_hubungan' => 'required|in:suami,istri,anak,famili lain',
            ]);
            
            // buat link foto kk
            $linkFotoKK = $this->uploadFile($request, 'link_foto_kk', 'foto-kk');

            // buat instance keluarga (eloquent orm)
            $keluarga = new Keluarga();
            $keluarga->no_kk = $request->no_kk;
            $keluarga->kepala_keluarga_id = $request->kepala_keluarga_id;
            $keluarga->link_foto_kk = $linkFotoKK;
            $keluarga->save();

            // buat instance anggota keluarga (eloquent orm)
            $anggotaKeluarga = new AnggotaKeluarga();
            $anggotaKeluarga->keluarga_id = $keluarga->id;
            $anggotaKeluarga->warga_id = $request->warga_id;
            $anggotaKeluarga->status_hubungan = $request->status_hubungan;
            $anggotaKeluarga->save();

            return response()->json([
                'success' => true,
                'message' => 'Data keluarga berhasil disimpan'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([ 
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([ 
                'success' => false,
                'message' => 'Gagal menambahkan data:' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadFile(Request $request, $inputName, $path, $oldFile = null)
    {
        if ($request->hasFile(($inputName))) {
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
            return $request->file($inputName)->store($path, 'public');

        }
        return $oldFile;
    }

    public function search(Request $request)
    {
        try {
            if ($request->has('q') && !empty($request->q)) {
                $q = $request->input('q');
                $query = Keluarga::with(['kepalaKeluarga', 'anggotaKeluarga.warga']);
                
                $query->where(function ($qe) use ($q) {
                    $qe->where('no_kk', 'like', "%$q%")
                      ->orWhereHas('kepalaKeluarga', function ($subQuery) use ($q) {
                          $subQuery->where('nama_lengkap', 'like', "%$q%");
                      })
                      ->orWhereHas('anggotaKeluarga.warga', function ($subQuery) use ($q) {
                          $subQuery->where('nama_lengkap', 'like', "%$q%");
                      });
                });

                $keluarga = $query->paginate(5);
            
            } else {
                $keluarga = Keluarga::with(['kepalaKeluarga', 'anggotaKeluarga.warga'])->paginate(5);
            }

            return response()->json($keluarga);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat pencarian: ' . $e->getMessage()
            ], 500);
        }
    }
}
