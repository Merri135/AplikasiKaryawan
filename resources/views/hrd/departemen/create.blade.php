@extends('layout.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Departemen</h1>
</div>

<div class="row">
    <div class="col">
        <form action="{{ route('hrd.departemen.store') }}" method="POST">
            @csrf

            <div class="card shadow">
                <div class="card-body">

                    {{-- Nama Departemen --}}
                    <div class="form-group mb-3">
                        <label for="nama_departemen">Name Divisi</label>
                        <input 
                            type="text" 
                            class="form-control @error('nama_departemen') is-invalid @enderror" 
                            id="nama_departemen" 
                            name="nama_departemen" 
                            placeholder="Masukkan Nama Departemen">

                        @error('nama_departemen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">
                        <label for="deskripsi">Description</label>
                        <input 
                            type="text" 
                            class="form-control @error('deskripsi') is-invalid @enderror" 
                            id="deskripsi" 
                            name="deskripsi" 
                            placeholder="Masukkan Deskripsi">

                        @error('deskripsi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Footer Button --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-end" style="gap: 10px;">
                        <a href="{{ route('hrd.departemen.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>

@endsection
