<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #e8e8e8; }
        h2, h4 { text-align: center; margin: 0; padding: 0; }
        
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .footer {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        .rekap-box {
            margin-top: 15px;
            border: 1px solid #333;
            padding: 10px;
        }

        .rekap-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN CUTI KARYAWAN</h2>
    <h4>Departemen: {{ $departemenNama }}</h4>
    <h4>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</h4>
</div>

<div class="rekap-box">
    <div class="rekap-title">REKAPITULASI</div>
    <table width="40%">
        <tr>
            <th>Total Pengajuan</th>
            <td>{{ $rekap['total'] }}</td>
        </tr>
        <tr>
            <th>Disetujui</th>
            <td>{{ $rekap['disetujui'] }}</td>
        </tr>
        <tr>
            <th>Pending</th>
            <td>{{ $rekap['pending'] }}</td>
        </tr>
        <tr>
            <th>Ditolak</th>
            <td>{{ $rekap['ditolak'] }}</td>
        </tr>
    </table>
</div>

<br>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Karyawan</th>
            <th>Departemen</th>
            <th>Jenis Cuti</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Status</th>
            <th>Disetujui Oleh</th>
            <th>Tgl Disetujui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cutis as $i => $c)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $c->karyawan->user->nama }}</td>
            <td>{{ $c->karyawan->departemen->nama_departemen }}</td>
            <td>{{ $c->jeniscuti->nama_jenis }}</td>
            <td>{{ $c->tanggal_mulai }} - {{ $c->tanggal_selesai }}</td>
            <td>{{ $c->jumlah_hari }}</td>
            <td>{{ ucfirst($c->status) }}</td>
            <td>{{ $c->disetujuiOleh->nama ?? '-' }}</td>
            <td>{{ $c->tanggal_disetujui ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Dicetak otomatis oleh sistem — {{ config('app.name') }}
</div>

</body>
</html>
                        