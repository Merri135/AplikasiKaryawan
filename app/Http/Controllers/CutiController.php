<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CutiExport;
use App\Models\Cuti;
use App\Models\Karyawan;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::where('user_id', Auth::id())->first();
        $cutis = Cuti::where('karyawan_id', $karyawan->id)
        ->with('jenisCuti')
        ->latest()
        ->paginate(5);

        return view('hrd.karyawan.cuti.index', compact('cutis'));
    }

    public function create()
    {
        $jenisCutis = JenisCuti::paginate(5);
        return view('hrd.karyawan.cuti.create', compact('jenisCutis'));
    }

    // =============================== STORE CUTI ===============================
   public function store(Request $request)
{
    $request->validate([
        'karyawan_id' => 'required',
        'jenis_cuti_id' => 'required',
        'tanggal_mulai' => 'required|date',
        'jumlah_hari' => 'required|numeric|min:0.5',
        'alasan' => 'required'
    ]);

    $karyawan = Karyawan::findOrFail($request->karyawan_id);

    // Ambil jumlah hari dari input user (float)
    $jumlahHari = (float)$request->jumlah_hari;

    // Validasi sisa cuti
    if ($jumlahHari > $karyawan->hitung_sisa_cuti) {
        return back()->with('error', 'Jumlah cuti melebihi sisa cuti!');
    }

    Cuti::create([
        'karyawan_id' => $request->karyawan_id,
        'jenis_cuti_id' => $request->jenis_cuti_id,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_mulai,
        'jumlah_hari' => $jumlahHari,
        'alasan' => $request->alasan,
        'status' => 'pending',
    ]);

    return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil diajukan.');
}


    // ✅ Detail pengajuan cuti
    public function show($id)
{
    $cuti = Cuti::with(['karyawan', 'jenisCuti', 'disetujuiOleh'])->findOrFail($id);

    return view('hrd.karyawan.cuti.show', compact('cuti'));
}
public function destroy($id)
{
    $cuti = Cuti::findOrFail($id);

    // Optional: Cegah hapus jika status sudah disetujui
    if ($cuti->status == 'disetujui') {
        return redirect()->back()->with('error', 'Pengajuan cuti yang sudah disetujui tidak bisa dihapus.');
    }
    $cuti->delete();

    return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dihapus.');
}


    // Halaman SPV melihat daftar pengajuan pending
public function spvIndex()
{
    $user = Auth::user();  // supervisor login

    $cutis = Cuti::whereHas('karyawan', function ($q) use ($user) {
        $q->where('supervisor_id', $user->id);
    })
    ->where('status', 'pending') // hanya tampil pending
    ->with(['karyawan', 'jenisCuti'])
    ->orderBy('created_at', 'desc')
    ->get();

    return view('supervisor.cuti.index', compact('cutis'));
}

// Supervisor menyetujui pengajuan
public function approve($id)
{
    $cuti = Cuti::findOrFail($id);

    $cuti->update([
        'status' => 'disetujui',
        'disetujui_oleh' => Auth()->id(),
        'tanggal_disetujui' => now(),
    ]);

    return redirect()->route('supervisor.cuti.index')->with('success', 'Pengajuan cuti berhasil disetujui.');
}

public function reject(Request $request, $id)
{
    $request->validate([
        'alasan_ditolak' => 'required|string'
    ]);

    $cuti = Cuti::findOrFail($id);

    $cuti->update([
        'status' => 'ditolak',
        'alasan_ditolak' => $request->alasan_ditolak,
        'disetujui_oleh' => Auth::id(),
        'tanggal_disetujui' => now(),
    ]);

    return redirect()->route('supervisor.cuti.index')->with('success', 'Pengajuan cuti berhasil ditolak.');
}

// RIWAYAT CUTI SUPERVISOR
public function spvRiwayat()
{
    $user = Auth::user();

    $riwayat = Cuti::whereHas('karyawan', function ($q) use ($user) {
                $q->where('supervisor_id', $user->id);
            })
            ->with(['karyawan.user', 'jenisCuti', 'disetujuiOleh'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

    return view('supervisor.cuti.riwayat', compact('riwayat'));
}

    // ✅ HRD melihat semua pengajuan cuti

   public function hrdIndex(Request $request)
{
    $query = Cuti::with(['karyawan.user', 'karyawan.departemen', 'jeniscuti', 'disetujuiOleh']);

    // Filter berdasarkan departemen
    if ($request->filled('departemen_id')) {
        $query->whereHas('karyawan', function ($q) use ($request) {
            $q->where('departemen_id', $request->departemen_id);
        });
    }

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan rentang tanggal
    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $query->whereBetween('tanggal_mulai', [
            $request->tanggal_mulai,
            $request->tanggal_selesai
        ]);
    }

    $cutis = $query->orderBy('created_at', 'desc')->paginate(5);


    // Ambil daftar departemen untuk dropdown
    $departemens = \App\Models\Departemen::all();

    return view('hrd.cuti.index', compact('cutis', 'departemens', 'request'));
}

public function riwayatKaryawan()
{
    $user = Auth::user();

    $karyawan = \App\Models\Karyawan::where('user_id', $user->id)->first();

    $riwayat = \App\Models\Cuti::with(['jenisCuti', 'disetujuiOleh'])
                ->where('karyawan_id', $karyawan->id)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('hrd.karyawan.cuti.riwayat', compact('riwayat'));
}

// Export to PDF
private function filteredCuti(Request $request)
{
    $query = Cuti::with(['karyawan.user', 'karyawan.departemen', 'jeniscuti', 'disetujuiOleh']);

    if ($request->filled('departemen_id')) {
        $query->whereHas('karyawan', function ($q) use ($request) {
            $q->where('departemen_id', $request->departemen_id);
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('tanggal_mulai')) {
        $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
    }

    if ($request->filled('tanggal_selesai')) {
        $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
    }

    return $query->orderBy('created_at', 'desc')->get();
}
public function exportPdf(Request $request)
{
    $cutis = $this->filteredCuti($request);

    // Hitung rekap
    $rekap = [
        'total'      => $cutis->count(),
        'disetujui'  => $cutis->where('status', 'disetujui')->count(),
        'pending'    => $cutis->where('status', 'pending')->count(),
        'ditolak'    => $cutis->where('status', 'ditolak')->count(),
    ];

    // Judul otomatis berdasarkan divisi (jika difilter)
    $departemenNama = "Semua Departemen";
    
    if ($request->filled('departemen_id')) {
        $departemen = \App\Models\Departemen::find($request->departemen_id);
        if ($departemen) {
            $departemenNama = $departemen->nama_departemen;
        }
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'hrd.cuti.exportpdf',
        compact('cutis', 'rekap', 'departemenNama')
    )->setPaper('A4', 'landscape');

    return $pdf->download('laporan-cuti-' . str_replace(' ', '_', $departemenNama) . '.pdf');
}
// Export to Excel
public function exportExcel(Request $request)
{
    $cutis = $this->filteredCuti($request);

    // Hitung rekap
    $rekap = [
        'total'      => $cutis->count(),
        'disetujui'  => $cutis->where('status', 'disetujui')->count(),
        'pending'    => $cutis->where('status', 'pending')->count(),
        'ditolak'    => $cutis->where('status', 'ditolak')->count(),
    ];

    $departemenNama = "Semua Departemen";
    if ($request->filled('departemen_id')) {
        $d = \App\Models\Departemen::find($request->departemen_id);
        if ($d) {
            $departemenNama = $d->nama_departemen;
        }
    }

    return Excel::download(
        new CutiExport($cutis, $rekap, $departemenNama),
        'laporan-cuti-' . str_replace(' ', '_', $departemenNama) . '.xlsx'
    );
}

}