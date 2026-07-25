<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user,
            'dashboardRoute' => $this->dashboardByRole($user->role)
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Update nama
        $user->nama = $request->nama;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto
        if ($request->hasFile('foto')) {

            $path = public_path('foto_profile');

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Hapus foto lama
            if ($user->foto && file_exists($path . '/' . $user->foto)) {
                unlink($path . '/' . $user->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($path, $filename);

            $user->foto = $filename;
        }

        $user->save();

        // Redirect sesuai role
        return redirect()
            ->route($this->dashboardByRole($user->role))
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Helper route dashboard sesuai role
     */
    private function dashboardByRole($role)
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'supervisor' => 'supervisor.dashboard',
            'hrd' => 'hrd.dashboard',
            'karyawan' => 'hrd.karyawan.dashboard',
            default => 'login',
        };
    }
}
