<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JenisCuti;

class CutiController extends Controller
{
    // ==========================
    // GET /api/cuti
    // ==========================
    public function index()
    {
        $cutis = Cuti::with([
            'karyawan.user',
            'karyawan.departemen',
            'jeniscuti',
            'disetujuiOleh'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data cuti berhasil diambil.',
            'data' => $cutis
        ]);
    }

    // ==========================
    // POST /api/cuti
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'     => 'required',
            'jenis_cuti_id'   => 'required',
            'tanggal_mulai'   => 'required|date',
            'jumlah_hari'     => 'required|numeric|min:0.5',
            'alasan'          => 'required|string'
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        if ($request->jumlah_hari > $karyawan->hitung_sisa_cuti) {

            return response()->json([
                'success' => false,
                'message' => 'Jumlah cuti melebihi sisa cuti.'
            ],422);
        }

        $cuti = Cuti::create([

            'karyawan_id'      => $request->karyawan_id,
            'jenis_cuti_id'    => $request->jenis_cuti_id,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_mulai,
            'jumlah_hari'      => $request->jumlah_hari,
            'alasan'           => $request->alasan,
            'status'           => 'pending'

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan cuti berhasil.',
            'data' => $cuti
        ],201);
    }

    // ==========================
    // GET /api/cuti/{id}
    // ==========================
    public function show($id)
    {
        $cuti = Cuti::with([
            'karyawan.user',
            'karyawan.departemen',
            'jeniscuti',
            'disetujuiOleh'
        ])->find($id);

        if(!$cuti){

            return response()->json([
                'success'=>false,
                'message'=>'Data tidak ditemukan.'
            ],404);
        }

        return response()->json([
            'success'=>true,
            'data'=>$cuti
        ]);
    }

    // ==========================
    // PUT /api/cuti/{id}
    // ==========================
    public function update(Request $request,$id)
    {
        $cuti = Cuti::find($id);

        if(!$cuti){

            return response()->json([
                'success'=>false,
                'message'=>'Data tidak ditemukan.'
            ],404);
        }

        $request->validate([

            'tanggal_mulai'=>'required|date',
            'jumlah_hari'=>'required|numeric|min:0.5',
            'alasan'=>'required|string'

        ]);

        $cuti->update([

            'tanggal_mulai'=>$request->tanggal_mulai,
            'tanggal_selesai'=>$request->tanggal_mulai,
            'jumlah_hari'=>$request->jumlah_hari,
            'alasan'=>$request->alasan

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Data berhasil diubah.',
            'data'=>$cuti
        ]);
    }

    // ==========================
    // DELETE /api/cuti/{id}
    // ==========================
    public function destroy($id)
    {
        $cuti = Cuti::find($id);

        if(!$cuti){

            return response()->json([
                'success'=>false,
                'message'=>'Data tidak ditemukan.'
            ],404);
        }

        if($cuti->status=='disetujui'){

            return response()->json([
                'success'=>false,
                'message'=>'Cuti yang telah disetujui tidak dapat dihapus.'
            ],422);
        }

        $cuti->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Data berhasil dihapus.'
        ]);
    }

    // ==========================
    // PATCH /api/cuti/{id}/approve
    // ==========================
    public function approve($id)
    {
        $cuti = Cuti::find($id);

        if(!$cuti){

            return response()->json([
                'success'=>false,
                'message'=>'Data tidak ditemukan.'
            ],404);
        }

        $cuti->update([

            'status'=>'disetujui',
            'disetujui_oleh'=>Auth::id(),
            'tanggal_disetujui'=>now()

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Pengajuan cuti berhasil disetujui.',
            'data'=>$cuti
        ]);
    }

    // ==========================
    // PATCH /api/cuti/{id}/reject
    // ==========================
    public function reject(Request $request,$id)
    {
        $request->validate([
            'alasan_ditolak'=>'required|string'
        ]);

        $cuti = Cuti::find($id);

        if(!$cuti){

            return response()->json([
                'success'=>false,
                'message'=>'Data tidak ditemukan.'
            ],404);
        }

        $cuti->update([

            'status'=>'ditolak',
            'alasan_ditolak'=>$request->alasan_ditolak,
            'disetujui_oleh'=>Auth::id(),
            'tanggal_disetujui'=>now()

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Pengajuan cuti berhasil ditolak.',
            'data'=>$cuti
        ]);
    }
}