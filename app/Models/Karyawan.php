<?php

namespace App\Models;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Cuti;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'IdBadge',
    'jabatan',
    'join_date',
    'departemen_id',
    'no_hp',
    'supervisor_id',
    'sisa_cuti'
];
protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }


    public function cutis()
    {
        return $this->hasMany(Cuti::class);
    }

    public function getHitungSisaCutiAttribute()
{
    $today = \Carbon\Carbon::now();
    $masaKerja = \Carbon\Carbon::parse($this->join_date)->diffInYears($today);

    $jatahCuti = ($masaKerja >= 1) ? $masaKerja * 12 : 12;

    $cutiTerpakai = $this->cutis()
        ->where('status', 'disetujui')
        ->sum('jumlah_hari');

    $sisaCuti = $jatahCuti - $cutiTerpakai;

    // Pertahankan pecahan kelipatan 0.5
    return max(0, round($sisaCuti * 2) / 2);
}


}
