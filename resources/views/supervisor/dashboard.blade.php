@extends('layout.app')

@section('content')
<div class="container">

    <div class="row">
        <!-- CARD 3 — Disetujui -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-dark fw-bold">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-circle-check fa-2x text-success mb-4"></i>
                    <div class="d-flex flex-column m-2" >
                        <p class="m-0">Disetujui</p>
                        <h3 class="m-0">{{ $disetujui }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 4 — Ditolak -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-dark fw-bold">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-circle-xmark fa-2x text-danger mb-4"></i>
                    <div class="d-flex flex-column m-2" >
                        <p class="m-0">Ditolak</p>
                        <h3 class="m-0">{{ $ditolak }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 5 — Pending -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-dark fw-bold">
                <div class="card-body d-flex align-items-center">
                    <i class="fa-solid fa-clock fa-2x text-warning mb-4"></i>
                    <div class="d-flex flex-column m-2" >
                        <p class="m-0">Pending</p>
                        <h3 class="m-0">{{ $pending }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
