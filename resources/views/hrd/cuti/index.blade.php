@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3 text-dark fw-bold">Laporan Pengajuan Cuti</h4>

    {{-- Form Filter --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body card-body-fix card-light">
            <form method="GET" action="{{ route('hrd.cuti.index') }}" class="row g-3">
                
                <div class="col-md-3 fw-bold text-dark text-center">
                    <label>Divisi</label>
                    <select name="departemen_id" class="form-control">
                        <option value="">-- Divisi All --</option>
                        @foreach($departemens as $d)
                            <option value="{{ $d->id }}" {{ $request->departemen_id == $d->id ? 'selected' : '' }}>
                                {{ $d->nama_departemen }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 fw-bold text-dark text-center">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- All --</option>
                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ $request->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $request->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a href="{{ route('hrd.cuti.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Hasil --}}
    <div class="card">
        <div class="card-body mb-4 shadow-sm border-1">

            {{-- Export Buttons --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('hrd.cuti.exportexcel', request()->query()) }}" 
                   class="btn btn-success me-2 mr-2">
                    <i class="fas fa-file-excel"></i>
                </a>

                <a href="{{ route('hrd.cuti.exportpdf', request()->query()) }}" 
                   class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i>
                </a>
            </div>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light shadow-sm text-center fw-bold text-dark">
                    <tr>
                        <th>No</th>
                        <th>Name Employee</th>
                        <th>Divisi</th>
                        <th>Leave Request</th>
                        <th>Leave Date</th>
                        <th>Total Days</th>
                        <th>Status</th>
                        <th>Approved By</th>
                        <th>Approved Date</th>
                    </tr>
                </thead>
                <tbody class="text-dark text-center fw-normal">
                    @forelse($cutis as $index => $c)
                    <tr>
                        <td>{{ $cutis->firstItem() + $index }}</td>
                        <td>{{ $c->karyawan->user->nama ?? '-' }}</td>
                        <td>{{ $c->karyawan->departemen->nama_departemen ?? '-' }}</td>
                        <td>{{ $c->jenisCuti->nama_jenis }}</td>
                        <td>{{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}</td>
                        <td>{{ $c->jumlah_hari }}</td>
                        <td>
                            @if($c->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($c->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $c->disetujuiOleh->nama ?? '-' }}</td>
                        <td>{{ $c->tanggal_disetujui ? date('d-m-Y', strtotime($c->tanggal_disetujui)) : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Tidak ada data cuti ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($cutis instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                <div>
                    Showing {{ $cutis->firstItem() }} to {{ $cutis->lastItem() }} of {{ $cutis->total() }} results
                </div>

                <div>
                    {{ $cutis->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
