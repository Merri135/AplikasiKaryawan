<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historicuti extends Model
{
    protected $fillable = [
        'disetujui_oleh',
        'cuti_id',
        'status',
        'keterangan',
    ];  
    public function disetujiOleh()
    {
        return $this->belongsTo(Karyawan::class, 'disetuji_oleh');
    }
    public function cuti()
    {
        return $this->belongsTo(Cuti::class);
    }
    
}
