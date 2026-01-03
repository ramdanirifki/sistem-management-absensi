<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalAbsensi;

class JadwalAbsensiSeeder extends Seeder
{
  public function run()
  {
    $jadwals = [
      [
        'nama_jadwal' => 'Reguler Pagi',
        'kode_jadwal' => 'REG-PAGI',
        'jam_masuk' => '08:00',
        'jam_pulang' => '17:00',
        'toleransi_keterlambatan' => 15,
        'is_default' => true,
        'keterangan' => 'Jadwal kerja reguler pagi'
      ],
      [
        'nama_jadwal' => 'Reguler Siang',
        'kode_jadwal' => 'REG-SIANG',
        'jam_masuk' => '13:00',
        'jam_pulang' => '22:00',
        'toleransi_keterlambatan' => 15,
        'is_default' => false,
        'keterangan' => 'Jadwal kerja reguler siang'
      ],
      [
        'nama_jadwal' => 'Shift A',
        'kode_jadwal' => 'SHIFT-A',
        'jam_masuk' => '07:00',
        'jam_pulang' => '15:00',
        'toleransi_keterlambatan' => 10,
        'is_default' => false,
        'keterangan' => 'Shift pagi'
      ],
      [
        'nama_jadwal' => 'Shift B',
        'kode_jadwal' => 'SHIFT-B',
        'jam_masuk' => '15:00',
        'jam_pulang' => '23:00',
        'toleransi_keterlambatan' => 10,
        'is_default' => false,
        'keterangan' => 'Shift sore'
      ]
    ];

    foreach ($jadwals as $jadwal) {
      JadwalAbsensi::create($jadwal);
    }
  }
}
