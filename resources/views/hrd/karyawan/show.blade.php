@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4" style="font-weight: 700; color:#333;">Detail Karyawan</h3>

    <table class="table table-bordered" style="background: #fff;">
        <tr>
            <th style="width: 250px; font-weight:700; color:#333;">Nama</th>
            <td style="color:#333;">{{ $karyawan->user->nama }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">ID Badge</th>
            <td style="color:#333;">{{ $karyawan->IdBadge }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">Position</th>
            <td style="color:#333;">{{ $karyawan->jabatan }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">Join Date</th>
            <td style="color:#333;">{{ $karyawan->join_date }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">Divisi</th>
            <td style="color:#333;">{{ $karyawan->departemen->nama_departemen ?? '-' }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">No Handphone</th>
            <td style="color:#333;">{{ $karyawan->no_hp }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">Name Supervisor</th>
            <td style="color:#333;">{{ $karyawan->supervisor->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th style="font-weight:700; color:#333;">Leave Balance</th>
            <td style="font-weight:700; color:#333;">{{ number_format($karyawan->hitung_sisa_cuti, 1) }} hari</td>
        </tr>
    </table>

    <a href="{{ route('hrd.karyawan.index') }}" class="btn btn-primary px-4">
        Kembali
    </a>

</div>
@endsection
