@extends('layout.app')

@section('content')
<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Data Cuti</h1>
     <a href="{{ route('hrd.jeniscuti.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Tambah Jenis Cuti</a>   
        </div>
    {{-- Notifikasi berhasil --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert">  <span aria-hidden="true">&times;</span></button>
</div>
@endif

    <table class="table table-bordered">
        <thead class="table-light text-center fw-bold text-dark">
            <tr>
                <th>No</th>
                <th>Leave Request</th>
                <th>Total Days</th>
                <th>Description</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-dark text-center fw-normal">
            @forelse($jenisCutis as $i => $jenis)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $jenis->nama_jenis }}</td>
                <td>{{ $jenis->kuota_hari }}</td>
                <td>{{ $jenis->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('hrd.jeniscuti.edit', $jenis->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                    <form action="{{ route('hrd.jeniscuti.destroy', $jenis->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data jenis cuti</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
