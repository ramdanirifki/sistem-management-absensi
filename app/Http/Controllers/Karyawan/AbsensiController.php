<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\LokasiPresensi;
use App\Models\JadwalAbsensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Halaman absensi
     */
    public function index()
    {
        $user = Auth::user();
        $pegawai = User::findOrFail($user->pegawai_id ?? $user->id);

        // Cek absensi hari ini
        $tanggalHariIni = Carbon::now()->format('Y-m-d');
        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        // Get active location presensi
        $lokasiAktif = LokasiPresensi::where('aktif', true)->first();

        // Get jadwal pegawai
        $jadwal = $pegawai->jadwalAbsensi ?? JadwalAbsensi::where('is_default', true)->first();

        // Kirim data ke view
        $waktuServer = Carbon::now();
        $tanggalUntukView = Carbon::now();

        return view('karyawan.absensi.index', compact(
            'pegawai',
            'absensiHariIni',
            'lokasiAktif',
            'jadwal',
            'waktuServer',
            'tanggalUntukView'
        ));
    }

    /**
     * Proses absensi masuk
     */
    public function masuk(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'catatan' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $pegawai = User::findOrFail($user->pegawai_id ?? $user->id);

        // Tanggal hari ini untuk query
        $tanggalQuery = Carbon::now()->format('Y-m-d');

        // Cek apakah sudah absen hari ini
        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggalQuery)
            ->first();

        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            return back()->with('error', 'Anda sudah melakukan absensi masuk hari ini!');
        }

        // Validasi lokasi
        $lokasiAktif = LokasiPresensi::where('aktif', true)->first();
        if (!$lokasiAktif) {
            return back()->with('error', 'Tidak ada lokasi presensi yang aktif!');
        }

        // Hitung jarak dari lokasi presensi
        $jarak = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $lokasiAktif->latitude,
            $lokasiAktif->longitude
        );

        // Cek apakah dalam radius
        if ($jarak > $lokasiAktif->radius_meter) {
            return back()->with('error', "Anda berada di luar radius presensi! (Jarak: " . round($jarak, 1) . "m, Radius: {$lokasiAktif->radius_meter}m)");
        }

        // Get jadwal
        $jadwal = $pegawai->jadwalAbsensi ?? JadwalAbsensi::where('is_default', true)->first();
        if (!$jadwal) {
            return back()->with('error', 'Jadwal absensi tidak ditemukan!');
        }

        // Cek jam absensi
        $jamSekarang = Carbon::now();
        $jamMasukJadwal = Carbon::createFromTimeString($jadwal->jam_masuk);

        // Validasi: tidak boleh absen terlalu awal (1 jam sebelum jam masuk)
        $jamMulaiAbsen = $jamMasukJadwal->copy()->subHours(1);
        if ($jamSekarang->lt($jamMulaiAbsen)) {
            $menitMenunggu = $jamMulaiAbsen->diffInMinutes($jamSekarang);
            return back()->with('error', "Belum waktunya absen masuk! Absen bisa dilakukan mulai " . $jamMulaiAbsen->format('H:i') . " (menunggu {$menitMenunggu} menit lagi)");
        }

        // Validasi: tidak boleh absen setelah jam pulang
        $jamPulangJadwal = Carbon::createFromTimeString($jadwal->jam_pulang);
        if ($jamSekarang->gt($jamPulangJadwal)) {
            return back()->with('error', "Sudah lewat jam pulang! Tidak bisa absen masuk setelah jam " . $jamPulangJadwal->format('H:i'));
        }

        $toleransi = $jadwal->toleransi_keterlambatan;

        // Tentukan status (HAPUS perhitungan menit terlambat)
        $batasWaktuMasuk = $jamMasukJadwal->copy()->addMinutes($toleransi);

        if ($jamSekarang->gt($batasWaktuMasuk)) {
            $statusMasuk = 'terlambat';
        } else {
            $statusMasuk = 'hadir';
        }

        // Simpan jam masuk
        $jamMasukTime = $jamSekarang->format('H:i:s');
        $tanggalHariIni = Carbon::now()->format('Y-m-d');

        // Buat atau update absensi
        try {
            $absensi = Absensi::updateOrCreate(
                [
                    'pegawai_id' => $pegawai->id,
                    'tanggal' => $tanggalHariIni,
                ],
                [
                    'jam_masuk' => $jamMasukTime,
                    'status_masuk' => $statusMasuk,
                    'latitude_masuk' => $request->latitude,
                    'longitude_masuk' => $request->longitude,
                    'catatan' => $request->catatan ? 'Masuk: ' . $request->catatan : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            $pesan = 'Absensi masuk berhasil! Status: ' .
                ($statusMasuk == 'terlambat' ? 'Terlambat' : 'Tepat waktu');

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            \Log::error('ERROR menyimpan absensi: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    /**
     * Proses absensi pulang
     */
    public function pulang(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'catatan' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $pegawai = User::findOrFail($user->pegawai_id ?? $user->id);

        // Tanggal hari ini untuk query
        $tanggalQuery = Carbon::now()->format('Y-m-d');

        // Cek apakah sudah absen masuk hari ini
        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggalQuery)
            ->first();

        if (!$absensiHariIni || !$absensiHariIni->jam_masuk) {
            return back()->with('error', 'Anda belum melakukan absensi masuk hari ini!');
        }

        if ($absensiHariIni->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absensi pulang hari ini!');
        }

        // Validasi lokasi
        $lokasiAktif = LokasiPresensi::where('aktif', true)->first();
        if (!$lokasiAktif) {
            return back()->with('error', 'Tidak ada lokasi presensi yang aktif!');
        }

        // Hitung jarak dari lokasi presensi
        $jarak = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $lokasiAktif->latitude,
            $lokasiAktif->longitude
        );

        // Cek apakah dalam radius
        if ($jarak > $lokasiAktif->radius_meter) {
            return back()->with('error', "Anda berada di luar radius presensi! (Jarak: " . round($jarak, 1) . "m, Radius: {$lokasiAktif->radius_meter}m)");
        }

        // Get jadwal
        $jadwal = $pegawai->jadwalAbsensi ?? JadwalAbsensi::where('is_default', true)->first();
        if (!$jadwal) {
            return back()->with('error', 'Jadwal absensi tidak ditemukan!');
        }

        // Cek jam pulang
        $jamSekarang = Carbon::now();
        $jamPulangJadwal = Carbon::createFromTimeString($jadwal->jam_pulang);

        // Tentukan status (HAPUS perhitungan menit cepat pulang)
        if ($jamSekarang->lt($jamPulangJadwal)) {
            $statusPulang = 'cepat';
        } else {
            $statusPulang = 'normal';
        }

        // Simpan jam pulang
        $jamPulangTime = $jamSekarang->format('H:i:s');

        // Pastikan jam pulang berbeda dari jam masuk
        if ($jamPulangTime === $absensiHariIni->jam_masuk) {
            $jamPulangTime = $jamSekarang->addMinute()->format('H:i:s');
        }

        // Gabungkan catatan masuk dan pulang
        $catatanGabungan = '';
        if ($absensiHariIni->catatan) {
            $catatanGabungan = $absensiHariIni->catatan;
        }
        if ($request->catatan) {
            if ($catatanGabungan) {
                $catatanGabungan .= ' | Pulang: ' . $request->catatan;
            } else {
                $catatanGabungan = 'Pulang: ' . $request->catatan;
            }
        }

        // Update absensi
        try {
            $absensiHariIni->update([
                'jam_pulang' => $jamPulangTime,
                'status_pulang' => $statusPulang,
                'latitude_pulang' => $request->latitude,
                'longitude_pulang' => $request->longitude,
                'catatan' => $catatanGabungan ?: $absensiHariIni->catatan,
                'updated_at' => Carbon::now(),
            ]);

            $pesan = 'Absensi pulang berhasil! ' .
                ($statusPulang == 'cepat' ? 'Cepat pulang' : 'Normal');

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            \Log::error('ERROR menyimpan absensi pulang: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan absensi pulang: ' . $e->getMessage());
        }
    }

    /**
     * Riwayat absensi
     */
    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $pegawai = User::findOrFail($user->pegawai_id ?? $user->id);

        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $absensi = Absensi::where('pegawai_id', $pegawai->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        $statistikBulanIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('
                COUNT(*) as total_hari,
                SUM(CASE WHEN status_masuk = "hadir" THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status_masuk = "terlambat" THEN 1 ELSE 0 END) as terlambat,
                SUM(CASE WHEN status_masuk = "tidak hadir" THEN 1 ELSE 0 END) as tidak_hadir
            ')
            ->first();

        return view('karyawan.absensi.riwayat', compact(
            'pegawai',
            'absensi',
            'statistikBulanIni',
            'bulan',
            'tahun'
        ));
    }

    /**
     * Calculate distance between two coordinates in meters
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
