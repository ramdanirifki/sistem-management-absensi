<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nip',
        'name',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'role',
        'jabatan_id',
        'status',
        'tanggal_masuk',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function jadwalAbsensi()
    {
        return $this->belongsTo(JadwalAbsensi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'pegawai_id');
    }
}
