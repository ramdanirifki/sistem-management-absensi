<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            [
                'nama' => 'Manager',
                'deskripsi' => 'Manajer perusahaan',
                'gaji_pokok' => 10000000,
                'tunjangan' => 3000000,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Supervisor',
                'deskripsi' => 'Supervisor divisi',
                'gaji_pokok' => 7500000,
                'tunjangan' => 2000000,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Staff IT',
                'deskripsi' => 'Staff teknologi informasi',
                'gaji_pokok' => 6000000,
                'tunjangan' => 1500000,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Staff HRD',
                'deskripsi' => 'Staff human resources',
                'gaji_pokok' => 5500000,
                'tunjangan' => 1000000,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Staff Marketing',
                'deskripsi' => 'Staff pemasaran',
                'gaji_pokok' => 5000000,
                'tunjangan' => 1200000,
                'status' => 'aktif',
            ],
        ];

        foreach ($jabatans as $jabatan) {
            Jabatan::create($jabatan);
        }
    }
}