<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ketidakhadiran;
use App\Models\User;
use Carbon\Carbon;

class KetidakhadiranSeeder extends Seeder
{
  public function run()
  {
    $contohData = [
      [
        'user_id' => 2,
        'jenis' => 'cuti',
        'tanggal_mulai' => '2024-01-15',
        'tanggal_selesai' => '2024-01-17',
        'durasi_hari' => 3,
        'alasan' => 'Cuti tahunan untuk refreshing',
        'bukti' => null,
        'status' => 'disetujui',
        'catatan_admin' => 'Cuti disetujui. Selamat berlibur!',
        'disetujui_oleh' => 1,
        'disetujui_pada' => '2024-01-10 09:00:00',
      ],
      [
        'user_id' => 3,
        'jenis' => 'sakit',
        'tanggal_mulai' => '2024-01-20',
        'tanggal_selesai' => '2024-01-20',
        'durasi_hari' => 1,
        'alasan' => 'Sakit demam tinggi',
        'bukti' => 'surat_sakit.jpg',
        'status' => 'disetujui',
        'catatan_admin' => 'Surat dokter sudah diterima. Cepat sembuh!',
        'disetujui_oleh' => 1,
        'disetujui_pada' => '2024-01-19 14:30:00',
      ],
      [
        'user_id' => 4,
        'jenis' => 'izin',
        'tanggal_mulai' => '2024-01-25',
        'tanggal_selesai' => '2024-01-25',
        'durasi_hari' => 1,
        'alasan' => 'Izin urusan keluarga',
        'bukti' => null,
        'status' => 'pending',
        'catatan_admin' => null,
        'disetujui_oleh' => null,
        'disetujui_pada' => null,
      ],
    ];

    foreach ($contohData as $data) {
      Ketidakhadiran::create($data);
    }
  }
}
