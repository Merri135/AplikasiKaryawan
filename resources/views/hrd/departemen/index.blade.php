@extends('layout.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Departemen</h1>

    <a href="{{ route('hrd.departemen.create') }}" 
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
    </a>
</div>

{{-- Notifikasi berhasil --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert">  <span aria-hidden="true">&times;</span></button>
</div>
@endif

<div class="row">
    <div class="col">
        <div class="card shadow mb-5">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center fw-bold text-dark">
                            <tr>
                                <th>No</th>
                                <th>Name Divisi</th>
                                <th>Description</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        @if ($departemens->count() < 1)
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center py-3">Tidak Ada Data</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody class="text-dark text-center fw-normal">
                            @foreach ($departemens as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_departemen }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <div class="d-flex justify-content-center mr-2">

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('hrd.departemen.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning d-inline-block mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('hrd.departemen.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                        <div>
                            Showing {{ $departemens->firstItem() }} to {{ $departemens->lastItem() }} 
                            of {{ $departemens->total() }} results
                        </div>
                        <div>
                            {{ $departemens->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
