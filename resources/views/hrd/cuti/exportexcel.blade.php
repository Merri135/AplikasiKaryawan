<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Karyawan</th>
            <th>Divisi</th>
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
            <td>{{ $c->tanggal_mulai }} s/d {{ $c->tanggal_selesai }}</td>
            <td>{{ $c->jumlah_hari }}</td>
            <td>{{ ucfirst($c->status) }}</td>
            <td>{{ $c->disetujuiOleh->nama ?? '-' }}</td>
            <td>{{ $c->tanggal_disetujui ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>