@extends('layout.app')

@section('content')

<div class="container-fluid">

    {{-- Baris 3 Kolom Utama --}}
    <div class="row g-4">

        {{-- Sisa Cuti --}}
        <div class="col-md-4">
            <div class="card shadow p-3">
                <p class="text-muted mb-1">Sisa Cuti</p>
                <h4 class="fw-bold">{{ ($sisaCuti) }} Hari</h4>
            </div>
        </div>

        {{-- Jabatan --}}
        <div class="col-md-4">
            <div class="card shadow p-3">
                <p class="text-muted mb-1">Jabatan</p>
                <h5 class="fw-bold">{{ $karyawan->jabatan ?? '-' }}</h5>
            </div>
        </div>

        {{-- Nama Karyawan --}}
        <div class="col-md-4">
            <div class="card shadow p-3">
                <p class="text-muted mb-1">Nama</p>
                <h5 class="fw-bold">{{ $karyawan->nama ?? Auth::user()->nama }}</h5>
            </div>
        </div>

    </div>

    {{-- Ajukan Cuti Box --}}
    <div class="row mt-4 mb-4">
        <div class="col-md-4">
            <div class="p-4 rounded shadow" style="background:#4f46e5; color:white;">
                <h5 class="fw-bold">Selamat datang di Sistem Cuti Karyawan!</h5>
                <a href="{{ route('cuti.index') }}" class="btn btn-success mt-3">
                    Ajukan Cuti
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
