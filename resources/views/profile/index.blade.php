@extends('layout.app')

@section('content')
<div class="container col-md-6">

    <h3 class="mb-3">Profil Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Foto Profil --}}
                <div class="text-center mb-3">
                    <img src="{{ $user->foto ? asset('foto_profile/'.$user->foto) : asset('template/img/undraw_profile.svg') }}"
                         class="rounded-circle mb-2"
                         width="120" height="120">

                    <input type="file" name="foto" class="form-control mt-2">
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" value="{{ $user->nama }}" class="form-control" required>
                </div>

                {{-- Email (readonly) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <!-- Tombol Kembali -->
             <a href="{{ route($dashboardRoute) }}" class="btn btn-secondary me-2">
        Kembali
             </a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
    </div>
</div>
@endsection
