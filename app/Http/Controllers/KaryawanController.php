<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use App\Models\Departemen;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with(['user', 'departemen', 'supervisor'])->paginate(5);
        return view('hrd.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        // Ambil user yang belum menjadi karyawan
        $users = User::where('role', 'karyawan')
            ->whereDoesntHave('karyawan')   // Filter supaya hanya yang belum memiliki relasi karyawan
            ->get();

        $supervisors = User::where('role', 'supervisor')->get();
        $departemens = Departemen::all();

        return view('hrd.karyawan.create', compact('users', 'supervisors', 'departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'IdBadge' => 'required|unique:karyawans',
            'jabatan' => 'required',
            'join_date' => 'required|date',
            'departemen_id' => 'required|exists:departemens,id',
            'no_hp' => 'required',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('hrd.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('hrd.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        // Pada edit, user tampilkan semua, tapi jangan tampilkan user lain yang sudah punya karyawan kecuali dirinya sendiri
        $users = User::where('role', 'karyawan')
            ->where(function ($query) use ($karyawan) {
                $query->whereDoesntHave('karyawan')
                      ->orWhere('id', $karyawan->user_id);
            })
            ->get();

        $supervisors = User::where('role', 'supervisor')->get();
        $departemens = Departemen::all();

        return view('hrd.karyawan.edit', compact('karyawan', 'users', 'supervisors', 'departemens'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
         $request->validate([
        'no_hp' => 'required|string|max:20',
    ]);

    // Update hanya kolom no_hp
    $karyawan->update([
        'no_hp' => $request->no_hp,
    ]);
        return redirect()->route('hrd.karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('hrd.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
