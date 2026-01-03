<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'gaji_pokok', 
        'tunjangan'
    ];

    protected $casts = [
        'gaji_pokok' => 'integer',
        'tunjangan' => 'integer'
    ];

    /**
     * Relasi ke model User
     */
    public function pegawai()
    {
        return $this->hasMany(User::class, 'jabatan_id');
    }

    /**
     * Scope untuk mendapatkan jabatan aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Accessor untuk gaji format
     */
    public function getGajiFormatAttribute()
    {
        return 'Rp ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    /**
     * Accessor untuk tunjangan format
     */
    public function getTunjanganFormatAttribute()
    {
        return 'Rp ' . number_format($this->tunjangan, 0, ',', '.');
    }
}
