@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3 class="text-dark mb-3 fw-bold">Edit Data Karyawan</h3>

    <form action="{{ route('hrd.karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered shadow-sm table-light">
            <tr>
                <th width="25%">User</th>
                <td>
                    <select name="user_id" class="form-select" disabled>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" @selected($u->id == $karyawan->user_id)>{{ $u->nama }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>ID Badge</th>
              <td>  <input type="text" name="IdBadge" class="form-control" value="{{ $karyawan->IdBadge }}" disabled></td>
            </tr>

            <tr>
                <th>Position</th>
                <td><input type="text" name="jabatan" class="form-control" value="{{ $karyawan->jabatan }}" disabled></td>
            </tr>

            <tr>
                <th>Join Date</th>
                <td><input type="date" name="join_date" class="form-control" value="{{ $karyawan->join_date }}" disabled></td>
            </tr>

            <tr>
                <th>Divisi</th>
                <td>
                    <select name="departemen_id" class="form-select" disabled>
                        @foreach($departemens as $d)
                            <option value="{{ $d->id }}" @selected($d->id == $karyawan->departemen_id)>{{ $d->nama_departemen }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th>No Handphone</th>
                <td><input type="text" name="no_hp" class="form-control" value="{{ $karyawan->no_hp }}" required></td>
            </tr>

            <tr>
                <th>Name Supervisor</th>
                <td>
                    <select name="supervisor_id" class="form-select" disabled>
                        <option value="">-- Select Supervisor --</option>
                        @foreach($supervisors as $s)
                            <option value="{{ $s->id }}" @selected($s->id == $karyawan->supervisor_id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <!-- BUTTON DI DALAM TABEL -->
            <tr>
                <td colspan="2" class="text-end" >
                    <div class="card-footer">
                <div class="d-flex justify-content-end" style="gap: 10px;">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="{{ route('hrd.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                </td>
</div>
            </tr>
        </table>

    </form>
</div>
@endsection
