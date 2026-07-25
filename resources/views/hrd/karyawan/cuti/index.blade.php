@extends('layout.app')

@section('content')
 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="text-dark fw-bold mb-0">Form Pengajuan Cuti</h3>
                       <a href="{{ route('cuti.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Ajukan Cuti</a>   
        </div>
    {{-- Notifikasi berhasil --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert">  <span aria-hidden="true">&times;</span></button>
</div>
@endif

{{-- Notifikasi error --}}
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('error') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

    <table class="table table-bordered">
        <thead class="table-light text-center fw-bold text-dark">
            <tr>
                <th>Leave Balance</th>
                <th>Leave Date</th>
                <th>Total Days</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-dark text-center fw-normal">
            @foreach($cutis as $c)
            <tr>
                <td>{{ $c->jenisCuti->nama_jenis }}</td>
                <td>{{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}</td>
                <td>{{ $c->jumlah_hari }}</td>
                <td class="text-center text-white bg-light fw-bold">
                    @if($c->status == 'pending')
                        <span class="badge bg-warning ">Pending</span>
                    @elseif($c->status == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>
                <td class="d-flex gap-2"><a href="{{ route('cuti.show', $c->id) }}" class="btn btn-info btn-sm mr-2"><i class="fas fa-eye"></i></a>
                <form action="{{ route('cuti.destroy', $c->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"> <i class="fas fa-trash-alt"></i> </button>
                </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                <div>
            Showing {{ $cutis->firstItem() }} to {{ $cutis->lastItem() }} of {{ $cutis->total() }} results
            </div>
            <div>
          {{ $cutis->links() }}
    </div>
</div>
@endsection
