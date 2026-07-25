<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartemenController extends Controller
{
    // Tampilkan semua departemen
    public function index()
    {
        if (Auth::user()->role !== 'hrd') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $departemens = Departemen::paginate(5);
        return view('hrd.departemen.index', compact('departemens'));
    }

    // Form Tambah Data
    public function create()
    {
        if (Auth::user()->role !== 'hrd') {
            abort(403);
        }

        return view('hrd.departemen.create');
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Departemen::create([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('hrd.departemen.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    // Form Edit
    public function edit($id)
    {
        if (Auth::user()->role !== 'hrd') {
            abort(403);
        }

        $departemen = Departemen::findOrFail($id);
        return view('hrd.departemen.edit', compact('departemen'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('hrd.departemen.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    // Hapus Data
    public function destroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('hrd.departemen.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
