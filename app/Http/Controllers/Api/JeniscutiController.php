<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    // Menampilkan semua data jenis cuti
    public function index()
    {
        $jenisCutis = JenisCuti::orderBy('nama_jenis')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis cuti berhasil diambil.',
            'data' => $jenisCutis
        ], 200);
    }

    // Menampilkan detail jenis cuti
    public function show($id)
    {
        $jenisCuti = JenisCuti::find($id);

        if (!$jenisCuti) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis cuti tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jenisCuti
        ], 200);
    }

    // Menambahkan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jeniscutis,nama_jenis',
            'kuota_hari' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $jenisCuti = JenisCuti::create([
            'nama_jenis' => $request->nama_jenis,
            'kuota_hari' => $request->kuota_hari,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis cuti berhasil ditambahkan.',
            'data' => $jenisCuti
        ], 201);
    }

    // Mengubah data
    public function update(Request $request, $id)
    {
        $jenisCuti = JenisCuti::find($id);

        if (!$jenisCuti) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis cuti tidak ditemukan.'
            ], 404);
        }

        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jeniscutis,nama_jenis,' . $id,
            'kuota_hari' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $jenisCuti->update([
            'nama_jenis' => $request->nama_jenis,
            'kuota_hari' => $request->kuota_hari,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis cuti berhasil diperbarui.',
            'data' => $jenisCuti
        ], 200);
    }

    // Menghapus data
    public function destroy($id)
    {
        $jenisCuti = JenisCuti::find($id);

        if (!$jenisCuti) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis cuti tidak ditemukan.'
            ], 404);
        }

        $jenisCuti->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis cuti berhasil dihapus.'
        ], 200);
    }
}