@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4>Form Pengajuan Cuti</h4>

{{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cuti.store') }}" method="POST">
        @csrf
        {{-- Hidden karyawan ID --}}
        <input type="hidden" name="karyawan_id" value="{{ auth()->user()->karyawan->id }}">
        <div class="mb-3">
            <label>Jenis Cuti</label>
            <select name="jenis_cuti_id" class="form-control">
                <option value="">-- Pilih Jenis Cuti --</option>
                @foreach($jenisCutis as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control">
            <small>Kosongkan jika cuti setengah hari</small>
        </div>
        <div class="mb-3">
    <label>Jumlah Hari Cuti</label>
    <input type="number" name="jumlah_hari" class="form-control" min="0.5" step="0.5" required>
    <small>Contoh: 0.5 / 1 / 1.5 / 2.5</small>
</div>

        <!-- <div class="mb-3">
            <label>Total Cuti</label>
            <select name="tipe_cuti" class="form-control" required>
            <option value="full">Cuti Full Day</option>
            <option value="half">Cuti Half Day (0.5)</option>
             </select>
        </div> -->
        <div class="mb-3">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
