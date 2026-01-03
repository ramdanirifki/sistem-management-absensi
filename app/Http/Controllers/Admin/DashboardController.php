<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\LokasiPresensi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    // Hitung statistik
    $totalPegawai = User::where('role', 'karyawan')->count();
    $totalJabatan = Jabatan::count();
    $totalLokasi = LokasiPresensi::count();

    // Hitung absensi hari ini
    $today = now()->format('Y-m-d');
    $absensiHariIni = Absensi::whereDate('tanggal', $today)->count();

    // Data absensi 7 hari terakhir
    $absensiMingguan = Absensi::selectRaw('tanggal, COUNT(*) as total')
      ->whereDate('tanggal', '>=', now()->subDays(7))
      ->groupBy('tanggal')
      ->orderBy('tanggal', 'asc')
      ->get();

    // Pegawai terlambat hari ini 
    $terlambatHariIni = Absensi::whereDate('tanggal', $today)
      ->where('status_masuk', 'terlambat') 
      ->count();

    // Pegawai tidak hadir hari ini 
    $tidakHadirHariIni = Absensi::whereDate('tanggal', $today)
      ->where('status_masuk', 'tidak_hadir') 
      ->count();

    // 5 absensi terbaru 
    $absensiTerbaru = Absensi::with(['pegawai' => function ($query) {
      $query->select('id', 'name'); 
    }])
      ->orderBy('created_at', 'desc')
      ->limit(5)
      ->get();

    // Statistik kehadiran bulan ini 
    $hadirBulanIni = Absensi::whereYear('tanggal', now()->year)
      ->whereMonth('tanggal', now()->month)
      ->where('status_masuk', 'hadir') 
      ->count();

    $terlambatBulanIni = Absensi::whereYear('tanggal', now()->year)
      ->whereMonth('tanggal', now()->month)
      ->where('status_masuk', 'terlambat') 
      ->count();

    return view('admin.dashboard', [
      'totalPegawai' => $totalPegawai,
      'totalJabatan' => $totalJabatan,
      'totalLokasi' => $totalLokasi,
      'absensiHariIni' => $absensiHariIni,
      'absensiMingguan' => $absensiMingguan,
      'terlambatHariIni' => $terlambatHariIni,
      'tidakHadirHariIni' => $tidakHadirHariIni,
      'absensiTerbaru' => $absensiTerbaru,
      'hadirBulanIni' => $hadirBulanIni,
      'terlambatBulanIni' => $terlambatBulanIni,
    ]);
  }
}
