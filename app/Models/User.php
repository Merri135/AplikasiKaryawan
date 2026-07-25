<?php

namespace App\Models;
use App\Models\Karyawan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * Kolom yang bisa diisi mass-assignment.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat model di-serialize.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang dikonversi ke tipe tertentu.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi: satu user punya satu karyawan.
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id');
    }

    public function cutisDisetujui()
    {
        return $this->hasMany(Cuti::class, 'disetujui_oleh');
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'supervisor_id');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    /**
     * Setter otomatis hash password.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value) && Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    // /**
    //  * Helper role.
    //  */
    // public function isAdmin()
    // {
    //     return $this->role === 'hrd';
    // }

    // public function isHRD()
    // {
    //     return $this->role === 'manajer';
    // }

    // public function isKaryawan()
    // {
    //     return $this->role === 'karyawan';
    // }
}
