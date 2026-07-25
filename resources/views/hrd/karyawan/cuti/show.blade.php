@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pengajuan Cuti</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered text-dark bg-light fw-bold">
                <tr>
                    <th width="30%">Name Employee</th>
                    <td>{{ $cuti->karyawan->user->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Leave Request</th>
                    <td>{{ $cuti->jenisCuti->nama_jenis }}</td>
                </tr>

                <tr>
                    <th>Start Date</th>
                    <td>{{ $cuti->tanggal_mulai }}</td>
                </tr>

                <tr>
                    <th>End Date</th>
                    <td>{{ $cuti->tanggal_selesai }}</td>
                </tr>

                <tr>
                    <th>Total Days</th>
                    <td>{{ $cuti->jumlah_hari }} hari</td>
                </tr>

                <tr>
                    <th>Reason</th>
                    <td>{{ $cuti->alasan }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if ($cuti->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif ($cuti->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>

                @if ($cuti->status == 'ditolak')
                <tr>
                    <th>Reason of Rejection</th>
                    <td>{{ $cuti->alasan_ditolak }}</td>
                </tr>
                @endif

                @if ($cuti->status == 'disetujui')
                <tr>
                    <th>Approved By</th>
                    <td>{{ $cuti->disetujuiOleh->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Approved Date</th>
                    <td>{{ $cuti->tanggal_disetujui }}</td>
                </tr>
                @endif
            </table>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
                Kembali
            </a>

        </div>
    </div>

</div>
@endsection
