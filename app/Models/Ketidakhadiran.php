<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketidakhadiran extends Model
{
  use HasFactory;

  protected $table = 'ketidakhadiran';

  protected $fillable = [
    'user_id', 
    'jenis',
    'tanggal_mulai',
    'tanggal_selesai',
    'durasi_hari',
    'alasan',
    'bukti',
    'status',
    'catatan_admin',
    'disetujui_oleh',
    'disetujui_pada'
  ];

  protected $casts = [
    'tanggal_mulai' => 'date',
    'tanggal_selesai' => 'date',
    'disetujui_pada' => 'datetime'
  ];

  // Relasi ke User
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // Relasi ke User (yang menyetujui)
  public function disetujuiOleh()
  {
    return $this->belongsTo(User::class, 'disetujui_oleh');
  }

  // Scope untuk filter
  public function scopeFilter($query, $filters)
  {
    if (isset($filters['jenis'])) {
      $query->where('jenis', $filters['jenis']);
    }

    if (isset($filters['status'])) {
      $query->where('status', $filters['status']);
    }

    if (isset($filters['user_id'])) {
      $query->where('user_id', $filters['user_id']);
    }

    if (isset($filters['bulan'])) {
      $query->whereMonth('tanggal_mulai', $filters['bulan']);
    }

    if (isset($filters['tahun'])) {
      $query->whereYear('tanggal_mulai', $filters['tahun']);
    }
  }

  // Accessor untuk status warna
  public function getStatusColorAttribute()
  {
    return match ($this->status) {
      'disetujui' => 'success',
      'pending' => 'warning',
      'ditolak' => 'danger',
      default => 'secondary'
    };
  }

  // Accessor untuk jenis warna
  public function getJenisColorAttribute()
  {
    return match ($this->jenis) {
      'cuti' => 'primary',
      'izin' => 'info',
      'sakit' => 'danger',
      default => 'secondary'
    };
  }

  // Method untuk cek apakah bisa di-edit
  public function getCanEditAttribute()
  {
    return $this->status === 'pending';
  }
}
