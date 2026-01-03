<?php
// app/Models/JadwalAbsensi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAbsensi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_absensi';

    protected $fillable = [
        'nama_jadwal',
        'kode_jadwal',
        'jam_masuk',
        'jam_pulang',
        'toleransi_keterlambatan',
        'is_default',
        'keterangan'
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
        'is_default' => 'boolean',
    ];

    // Scope untuk jadwal default
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function pegawai()
    {
        return $this->hasMany(User::class);
    }
}
