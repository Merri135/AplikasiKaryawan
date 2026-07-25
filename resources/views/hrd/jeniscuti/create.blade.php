@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4>Tambah Jenis Cuti Baru</h4>

    <form action="{{ route('hrd.jeniscuti.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Leave Balance</label>
            <input type="text" name="nama_jenis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Total Days</label>
            <input type="number" name="kuota_hari" class="form-control" value="12" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <a href="{{ route('hrd.jeniscuti.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
