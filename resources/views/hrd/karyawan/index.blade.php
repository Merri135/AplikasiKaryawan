@extends('layout.app')
@section('content')

     <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="text-dark fw-bold mb-0">Data Karyawan</h3>
                       <a href="{{ route('hrd.karyawan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>   
        </div>
        {{-- Notifikasi berhasil --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert">  <span aria-hidden="true">&times;</span></button>
</div>
@endif
   <table class="table table-bordered shadow-sm mb-4">
        <thead class="table-light text-center fw-bold text-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>ID Badge</th>
                <th>Divisi</th>
                <th>Position</th>
                <th>Leave Balance</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-dark text-center fw-normal">
            @foreach($karyawans as $k)
            <tr>
                <td>{{ $k->id }}</td>
                <td>{{ $k->user->nama }}</td>
                <td>{{ $k->IdBadge }}</td>
                <td>{{ $k->departemen->nama_departemen ?? '-' }}</td>
                <td>{{ $k->jabatan }}</td>
                <td>{{ number_format($k->hitung_sisa_cuti, 1) }} hari</td>
                <td>
                    <a href="{{ route('hrd.karyawan.show', $k->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('hrd.karyawan.edit', $k->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('hrd.karyawan.destroy', $k->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- {{ $karyawans->links() }} -->
</div>
</div>
@endsection