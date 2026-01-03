<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = User::where('status', 'aktif')->get();

        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        foreach ($pegawais as $pegawai) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                // Lewati hari weekend
                if (!$currentDate->isWeekend()) {
                    $jamMasuk = Carbon::createFromTime(8, rand(0, 30), 0);
                    $jamPulang = Carbon::createFromTime(16, rand(0, 59), 0);

                    $statusMasuk = 'hadir';
                    $statusPulang = 'normal';

                    // uat beberapa entri terlambat secara acak (30% kemungkinan)
                    if (rand(1, 10) > 7) {
                        $jamMasuk->addMinutes(rand(1, 45));
                        $statusMasuk = 'terlambat';
                    }

                    // Buat beberapa pulang cepat secara acak (20% kemungkinan)
                    if (rand(1, 10) > 8) {
                        $jamPulang->subMinutes(rand(1, 30));
                        $statusPulang = 'cepat';
                    }

                    // Buat beberapa entri tidak hadir secara acak (10% kemungkinan)
                    if (rand(1, 10) > 9) {
                        Absensi::create([
                            'pegawai_id' => $pegawai->id,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'jam_masuk' => null,
                            'jam_pulang' => null,
                            'status_masuk' => 'tidak hadir',
                            'status_pulang' => 'tidak absen',
                            'catatan' => 'Ijin sakit',
                        ]);
                    } else {
                        Absensi::create([
                            'pegawai_id' => $pegawai->id,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'jam_masuk' => $jamMasuk->format('H:i:s'),
                            'jam_pulang' => $jamPulang->format('H:i:s'),
                            'status_masuk' => $statusMasuk,
                            'status_pulang' => $statusPulang,
                            'catatan' => rand(1, 10) > 8 ? 'Meeting client' : null,
                        ]);
                    }
                }

                $currentDate->addDay();
            }
        }
    }
}
