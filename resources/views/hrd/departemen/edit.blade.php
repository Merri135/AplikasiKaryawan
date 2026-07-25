@extends('layout.app')

@section('content')

 <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Departemen</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ url('hrd/departemen/'.$departemen->id.'/update') }}" method="POST">
                @csrf
                @method('PUT')
            <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama_departemen">Name Divisi</label>
                    <input type="text" inputmode="text" class="form-control @error('nama_departemen') is-invalid @enderror" value="{{ old('nama_departemen', $departemen->nama_departemen) }}" id="nama_departemen" name="nama_departemen" placeholder="Masukkan Nama Departemen">  
                    @error('nama_departemen')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <input type="text" inputmode="text" class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi', $departemen->deskripsi) }}" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi">  
                    @error('deskripsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
<div>
            <div class="card-footer">
                <div class="d-flex justify-content-end" style="gap: 10px;">
                    <a href="/hrd/departemen" class="btn btn-outline-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-warning">Edit</button>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>

@endsection

