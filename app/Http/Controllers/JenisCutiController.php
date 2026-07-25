<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    // ✅ Tampilkan semua jenis cuti
    public function index()
    {
        $jenisCutis = JenisCuti::orderBy('nama_jenis')->get();
        return view('hrd.jeniscuti.index', compact('jenisCutis'));
    }

    // ✅ Form tambah jenis cuti
    public function create()
    {
        return view('hrd.jeniscuti.create');
    }

    // ✅ Simpan jenis cuti baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jeniscutis,nama_jenis',
            'kuota_hari' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        JenisCuti::create($request->only('nama_jenis', 'kuota_hari', 'keterangan'));

        return redirect()
            ->route('hrd.jeniscuti.index')
            ->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    // ✅ Form edit jenis cuti
    public function edit($id)
    {
        $jenisCuti = JenisCuti::findOrFail($id);
        return view('hrd.jeniscuti.edit', compact('jenisCuti'));
    }

    // ✅ Update data jenis cuti
    public function update(Request $request, $id)
    {
        $jenisCuti = JenisCuti::findOrFail($id);

        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jeniscutis,nama_jenis,' . $jenisCuti->id,
            'kuota_hari' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $jenisCuti->update($request->only('nama_jenis', 'kuota_hari', 'keterangan'));

        return redirect()
            ->route('hrd.jeniscuti.index')
            ->with('success', 'Jenis cuti berhasil diperbarui.');
    }

    // ✅ Hapus data
    public function destroy($id)
    {
        $jenisCuti = JenisCuti::findOrFail($id);
        $jenisCuti->delete();

        return redirect()
            ->route('hrd.jeniscuti.index')
            ->with('success', 'Jenis cuti berhasil dihapus.');
    }
}
