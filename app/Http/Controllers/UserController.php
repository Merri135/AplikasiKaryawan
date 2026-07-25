<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ Ambil semua user (JSON)
    public function ajaxList()
    {
        $users = User::orderBy('id', 'ASC')->get();
        return response()->json($users);
    }

    // ✅ Simpan user baru (AJAX)
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:karyawan,supervisor,hrd,admin',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['success' => true, 'message' => 'User berhasil ditambahkan.', 'user' => $user]);
    }

    // ✅ Tampilkan detail user untuk edit
    public function ajaxShow($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // ✅ Update user
    public function ajaxUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:karyawan,supervisor,hrd,admin',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only(['nama', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true, 'message' => 'User berhasil diperbarui.']);
    }

    // ✅ Hapus user
    public function ajaxDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
    }
}
