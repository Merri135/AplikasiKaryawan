<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

        // redirect based on role

            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('hrd')) {
                return redirect()->intended('/hrd/dashboard');   
            } elseif ($user->hasRole('supervisor')) {
                return redirect()->intended('/supervisor/dashboard');
            } else {
                return redirect()->intended('/hrd/karyawan/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email dan Password salah.',]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    //dashboard method
  public function karyawanDashboard()
{
    $user = Auth::user();

    $karyawan = \App\Models\Karyawan::with('cutis.jenisCuti')
                ->where('user_id', $user->id)
                ->first();

    // Ambil sisa cuti dari accessor
    $sisaCuti = $karyawan->hitung_sisa_cuti;
    $sisaCutiAsli = $karyawan->hitung_sisa_cuti;


    return view('hrd.karyawan.dashboard', [
        'karyawan' => $karyawan,
        'sisaCuti' => $sisaCuti,
        'sisaCutiAsli' => $sisaCutiAsli,
    ]);
}

    public function supervisorDashboard()
    {
        $pending   = \App\Models\Cuti::where('status', 'pending')->count();
    $disetujui = \App\Models\Cuti::where('status', 'disetujui')->count();
    $ditolak   = \App\Models\Cuti::where('status', 'ditolak')->count();

    return view('supervisor.dashboard', compact('pending','disetujui','ditolak'));
    }
    public function hrdDashboard()
{
    $pending   = \App\Models\Cuti::where('status', 'pending')->count();
    $disetujui = \App\Models\Cuti::where('status', 'disetujui')->count();
    $ditolak   = \App\Models\Cuti::where('status', 'ditolak')->count();

    return view('hrd.dashboard', compact('pending','disetujui','ditolak'));
}

    
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
