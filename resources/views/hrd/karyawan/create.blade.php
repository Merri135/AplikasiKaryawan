@extends('layout.app')
@section('content')

<div class="container mt-4">
    <h3>Tambah Karyawan</h3>
    <form action="{{ route('hrd.karyawan.store') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label>Name Employee</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Select Employee --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>ID Badge</label>
            <input type="text" name="IdBadge" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Position</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Join Date</label>
            <input type="date" name="join_date" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Divisi</label>
            <select name="departemen_id" class="form-select" required>
                @foreach($departemens as $d)
                    <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>No Handphone</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Name Supervisor</label>
            <select name="supervisor_id" class="form-select">
                <option value="">-- Select Supervisor --</option>
                @foreach($supervisors as $s)
                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="card-footer">
        <div class="d-flex justify-content-end" style="gap: 10px;">
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="{{ route('hrd.karyawan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
</div>
@endsection