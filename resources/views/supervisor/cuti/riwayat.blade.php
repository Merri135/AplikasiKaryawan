@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4>Riwayat Pengajuan Cuti Bawahan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Karyawan</th>
                <th>Jenis Cuti</th>
                <th>Tanggal</th>
                <th>Jumlah Hari</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                <th>Disetujui / Ditolak Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $c)
            <tr>
                <td>{{ $c->karyawan->user->nama }}</td>
                <td>{{ $c->jenisCuti->nama_jenis }}</td>
                <td>{{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}</td>
                <td>{{ $c->jumlah_hari }}</td>
                <td class="text-center text-white fw-bold">
                    @if($c->status == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($c->status == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>{{ $c->alasan_ditolak ?? '-' }}</td>
               <td>{{ $c->disetujuiOleh->nama ?? '-' }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada riwayat pengajuan cuti.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $riwayat->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
