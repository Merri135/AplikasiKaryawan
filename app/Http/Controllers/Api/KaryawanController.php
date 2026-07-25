<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    // GET /api/karyawan
    public function index()
    {
        $karyawan = Karyawan::with(['user', 'departemen', 'supervisor'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil diambil.',
            'data' => $karyawan
        ], 200);
    }

    // POST /api/karyawan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|exists:users,id',
            'IdBadge'        => 'required|unique:karyawans,IdBadge',
            'jabatan'        => 'required|string|max:255',
            'join_date'      => 'required|date',
            'departemen_id'  => 'required|exists:departemens,id',
            'no_hp'          => 'required|string|max:20',
            'supervisor_id'  => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $karyawan = Karyawan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil ditambahkan.',
            'data' => $karyawan
        ], 201);
    }

    // GET /api/karyawan/{id}
    public function show($id)
    {
        $karyawan = Karyawan::with(['user', 'departemen', 'supervisor'])->find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $karyawan
        ], 200);
    }

    // PUT /api/karyawan/{id}
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'no_hp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $karyawan->update([
            'no_hp' => $request->no_hp
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil diperbarui.',
            'data' => $karyawan
        ], 200);
    }

    // DELETE /api/karyawan/{id}
    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        $karyawan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil dihapus.'
        ], 200);
    }
}