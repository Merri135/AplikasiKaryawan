<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cutis';

    protected $fillable = [
        'karyawan_id',
        'jenis_cuti_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan',
        'status',
        'disetujui_oleh',
        'tanggal_disetujui',
        'alasan_ditolak',
    ];

    protected $casts = [
    'jumlah_hari' => 'float'
];

    // Relasi ke tabel Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // Relasi ke jenis cuti
    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'jenis_cuti_id');
    }

    // Relasi ke user yang menyetujui
    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
