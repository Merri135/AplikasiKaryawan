@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h3>Riwayat Cuti Saya</h3>
    <p class="text-muted">Semua pengajuan cuti Anda akan muncul di sini !! .</p>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Leave Date</th>
                        <th>Leave Request</th>
                        <th>Total Days</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Process Date</th>
                        <th>Rejection Note</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($riwayat as $cuti)
                    <tr>
                        <td>{{ $cuti->tanggal_mulai }} s/d {{ $cuti->tanggal_selesai }}</td>

                        <td>{{ $cuti->jenisCuti->nama_jenis }}</td>

                        <td>{{ $cuti->jumlah_hari }}</td>

                        <td>{{ $cuti->alasan ?? '-' }}</td>

                        <td class="text-center fw-bold text-white">
                            @if($cuti->status == 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($cuti->status == 'disetujui')
                                <span class="badge bg-success ">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        <td>
                            {{ $cuti->tanggal_disetujui ? date('d-m-Y', strtotime($cuti->tanggal_disetujui)) : '-' }}
                        </td>

                        <td>{{ $cuti->alasan_ditolak ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pengajuan cuti.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
