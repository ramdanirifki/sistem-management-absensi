<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
  {
    // User yang login langsung adalah "pegawai"
    $pegawai = auth()->user();

    // Absensi hari ini
    $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
      ->whereDate('tanggal', Carbon::today())
      ->first();

    // Statistik bulan ini
    $statistikBulanIni = DB::table('absensi')
      ->selectRaw('
                COUNT(*) as total_hari,
                SUM(CASE WHEN status_masuk = "hadir" THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status_masuk = "terlambat" THEN 1 ELSE 0 END) as terlambat,
                SUM(CASE WHEN status_masuk = "tidak hadir" THEN 1 ELSE 0 END) as tidak_hadir
            ')
      ->where('pegawai_id', $pegawai->id)
      ->whereMonth('tanggal', Carbon::now()->month)
      ->whereYear('tanggal', Carbon::now()->year)
      ->first();

    // Absensi 7 hari terakhir
    $absensiMingguan = Absensi::where('pegawai_id', $pegawai->id)
      ->whereDate('tanggal', '>=', Carbon::now()->subDays(7))
      ->orderBy('tanggal', 'desc')
      ->get();

    return view('karyawan.dashboard', compact(
      'pegawai',
      'absensiHariIni',
      'statistikBulanIni',
      'absensiMingguan'
    ));
  }
}
