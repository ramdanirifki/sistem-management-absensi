<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Hapus semua data users
        User::truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Data jabatan 
        $jabatanAdmin = Jabatan::firstOrCreate(
            ['nama' => 'Administrator'],
            [
                'deskripsi' => 'Admin Sistem',
                'gaji_pokok' => 10000000,
                'tunjangan' => 2000000,
                'status' => 'aktif'
            ]
        );

        $jabatanManager = Jabatan::firstOrCreate(
            ['nama' => 'Manager'],
            [
                'deskripsi' => 'Manager Perusahaan',
                'gaji_pokok' => 15000000,
                'tunjangan' => 3000000,
                'status' => 'aktif'
            ]
        );

        $jabatanStaffIT = Jabatan::firstOrCreate(
            ['nama' => 'Staff IT'],
            [
                'deskripsi' => 'Staff Teknologi Informasi',
                'gaji_pokok' => 7000000,
                'tunjangan' => 1500000,
                'status' => 'aktif'
            ]
        );

        $jabatanHROfficer = Jabatan::firstOrCreate(
            ['nama' => 'HR Officer'],
            [
                'deskripsi' => 'Officer Human Resources',
                'gaji_pokok' => 6500000,
                'tunjangan' => 1200000,
                'status' => 'aktif'
            ]
        );

        // Admin
        User::create([
            'nik' => 'ADMIN001',
            'nip' => 'PEG001',
            'name' => 'Admin Utama',
            'email' => 'admin@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-15',
            'agama' => 'Islam',
            'role' => 'admin',
            'jabatan_id' => $jabatanAdmin->id,
            'status' => 'aktif',
            'tanggal_masuk' => '2020-01-01',
            'foto' => null,
            'email_verified_at' => now(),
        ]);

        // Manager
        User::create([
            'nik' => 'MGR001',
            'nip' => 'PEG002',
            'name' => 'Manager Perusahaan',
            'email' => 'manager@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Sudirman No. 456, Jakarta',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1985-05-20',
            'agama' => 'Islam',
            'role' => 'admin', // Manager bisa juga admin
            'jabatan_id' => $jabatanManager->id,
            'status' => 'aktif',
            'tanggal_masuk' => '2019-03-10',
            'foto' => null,
            'email_verified_at' => now(),
        ]);

        // Karyawan
        User::create([
            'nik' => 'KRY001',
            'nip' => 'PEG003',
            'name' => 'Budi Santoso',
            'email' => 'budi@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081298765432',
            'alamat' => 'Jl. Melati No. 10, Jakarta',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1995-08-12',
            'agama' => 'Islam',
            'role' => 'karyawan',
            'jabatan_id' => $jabatanStaffIT->id,
            'status' => 'aktif',
            'tanggal_masuk' => '2024-01-15',
            'foto' => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nik' => 'KRY002',
            'nip' => 'PEG004',
            'name' => 'Siti Aminah',
            'email' => 'siti@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081312345678',
            'alamat' => 'Jl. Mawar No. 25, Jakarta',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '1993-11-05',
            'agama' => 'Islam',
            'role' => 'karyawan',
            'jabatan_id' => $jabatanHROfficer->id,
            'status' => 'aktif',
            'tanggal_masuk' => '2024-02-20',
            'foto' => null,
            'email_verified_at' => now(),
        ]);

        // Karyawan perempuan
        User::create([
            'nik' => 'KRY003',
            'nip' => 'PEG005',
            'name' => 'Dewi Lestari',
            'email' => 'dewi@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081377788899',
            'alamat' => 'Jl. Anggrek No. 7, Jakarta',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '1992-04-18',
            'agama' => 'Kristen',
            'role' => 'karyawan',
            'jabatan_id' => $jabatanStaffIT->id,
            'status' => 'aktif',
            'tanggal_masuk' => '2023-11-30',
            'foto' => null,
            'email_verified_at' => now(),
        ]);

        // Karyawan nonaktif
        User::create([
            'nik' => 'KRY004',
            'nip' => 'PEG006',
            'name' => 'Agus Supriyadi',
            'email' => 'agus@absensi.com',
            'password' => Hash::make('Password123'),
            'no_telepon' => '081399988877',
            'alamat' => 'Jl. Kenanga No. 33, Jakarta',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1990-09-25',
            'agama' => 'Katolik',
            'role' => 'karyawan',
            'jabatan_id' => $jabatanHROfficer->id,
            'status' => 'nonaktif',
            'tanggal_masuk' => '2022-06-15',
            'foto' => null,
            'email_verified_at' => now(),
        ]);
    }
}