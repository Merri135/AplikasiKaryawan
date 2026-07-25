<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    // GET /api/departemen
    public function index()
    {
        $departemen = Departemen::all();

        return response()->json([
            'success' => true,
            'message' => 'Data departemen berhasil diambil.',
            'data' => $departemen
        ], 200);
    }

    // POST /api/departemen
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $departemen = Departemen::create([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departemen berhasil ditambahkan.',
            'data' => $departemen
        ], 201);
    }

    // GET /api/departemen/{id}
    public function show($id)
    {
        $departemen = Departemen::find($id);

        if (!$departemen) {
            return response()->json([
                'success' => false,
                'message' => 'Departemen tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $departemen
        ], 200);
    }

    // PUT /api/departemen/{id}
    public function update(Request $request, $id)
    {
        $departemen = Departemen::find($id);

        if (!$departemen) {
            return response()->json([
                'success' => false,
                'message' => 'Departemen tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departemen berhasil diperbarui.',
            'data' => $departemen
        ], 200);
    }

    // DELETE /api/departemen/{id}
    public function destroy($id)
    {
        $departemen = Departemen::find($id);

        if (!$departemen) {
            return response()->json([
                'success' => false,
                'message' => 'Departemen tidak ditemukan.'
            ], 404);
        }

        $departemen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Departemen berhasil dihapus.'
        ], 200);
    }
}