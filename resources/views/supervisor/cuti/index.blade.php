@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4>Persetujuan Pengajuan Cuti</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Karyawan</th>
                <th>Jenis Cuti</th>
                <th>Tanggal</th>
                <th>Jumlah Hari</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $c)
            <tr>
                <td>{{ $c->karyawan->user->nama }}</td>
                <td>{{ $c->jenisCuti->nama_jenis }}</td>
                <td>{{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}</td>
                <td>{{ $c->jumlah_hari }}</td>
                <td>{{ $c->alasan }}</td>
                <td>
                    <form action="{{ route('supervisor.cuti.approve', $c->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                    </form>

                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $c->id }}">
                        Tolak
                    </button>

                    <!-- Modal Tolak -->
                    <div class="modal fade" id="modalTolak{{ $c->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="{{ route('supervisor.cuti.reject', $c->id) }}" method="POST">
                            @csrf
                            <div class="modal-header bg-danger text-white">
                              <h5 class="modal-title">Alasan Penolakan</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <textarea name="alasan_ditolak" class="form-control" required></textarea>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">Tolak</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
