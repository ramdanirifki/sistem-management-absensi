<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPresensi extends Model
{
  use HasFactory;

  protected $fillable = [
    'nama',
    'alamat',
    'latitude',
    'longitude',
    'radius_meter',
    'aktif'
  ];

  protected $casts = [
    'latitude' => 'decimal:8',
    'longitude' => 'decimal:8',
    'radius_meter' => 'integer',
    'aktif' => 'boolean'
  ];

  // Relasi ke presensi (jika ada)
  public function presensis()
  {
    return $this->hasMany(Presensi::class);
  }
}
