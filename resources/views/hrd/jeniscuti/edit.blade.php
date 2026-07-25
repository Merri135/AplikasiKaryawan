@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Jenis Cuti</h4>

    <form action="{{ route('hrd.jeniscuti.update', $jenisCuti->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Leave Request</label>
            <input type="text" name="nama_jenis" value="{{ old('nama_jenis', $jenisCuti->nama_jenis) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Total Days</label>
            <input type="number" name="kuota_hari" value="{{ old('kuota_hari', $jenisCuti->kuota_hari) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $jenisCuti->keterangan) }}</textarea>
        </div>
        <div class="card-footer">
                <div class="d-flex justify-content-end" style="gap: 10px;">
        <a href="{{ route('hrd.jeniscuti.index') }}" class="btn btn-secondary">Kembali</a>
         <button type="submit" class="btn btn-primary">Edit</button>
         </div>
    </form>
</div>
@endsection
