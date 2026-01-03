<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter
        $tanggal = $request->get('tanggal');
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $pegawai_id = $request->get('pegawai_id');

        // Query absensi dengan filter
        $absensiQuery = Absensi::with('pegawai')
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal', $tanggal);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->when($pegawai_id, function ($query, $pegawai_id) {
                return $query->where('pegawai_id', $pegawai_id);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('pegawai_id');

        // Pagination
        $perPage = $request->get('per_page', 20);
        $absensi = $absensiQuery->paginate($perPage)->withQueryString();

        // Data statistik 
        $statistik = $this->getStatistik($bulan, $tahun, $pegawai_id);

        // Ambil daftar pegawai untuk dropdown
        $pegawais = User::where('status', 'aktif')
            ->orderBy('name')
            ->get();

        return view('admin.rekap-absensi.index', compact(
            'absensi',
            'statistik',
            'pegawais',
            'tanggal',
            'bulan',
            'tahun',
            'pegawai_id'
        ));
    }

    private function getStatistik($bulan, $tahun, $pegawai_id = null)
    {
        $query = Absensi::query();

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        if ($pegawai_id) {
            $query->where('pegawai_id', $pegawai_id);
        }

        $result = $query->selectRaw('
            COUNT(*) as total_absensi,
            SUM(CASE WHEN status_masuk = "hadir" THEN 1 ELSE 0 END) as total_hadir,
            SUM(CASE WHEN status_masuk = "terlambat" THEN 1 ELSE 0 END) as total_terlambat,
            SUM(CASE WHEN status_masuk IS NULL OR status_masuk = "" OR status_masuk = "tidak hadir" THEN 1 ELSE 0 END) as total_tidak_hadir
        ')->first();

        return $result;
    }

    public function export(Request $request)
    {
        // Ambil parameter filter
        $tanggal = $request->get('tanggal');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $pegawai_id = $request->get('pegawai_id');

        // Query data untuk export
        $absensi = Absensi::with('pegawai')
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal', $tanggal);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->when($pegawai_id, function ($query, $pegawai_id) {
                return $query->where('pegawai_id', $pegawai_id);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('pegawai_id')
            ->get();

        // Generate CSV
        $filename = "rekap-absensi-" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($absensi) {
            $file = fopen('php://output', 'w');

            // Header dengan BOM untuk Excel
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Nama Pegawai',
                'NIK',
                'Tanggal',
                'Jam Masuk',
                'Jam Pulang',
                'Status Masuk',
                'Status Pulang',
                // HAPUS: 'Menit Terlambat', 'Menit Cepat Pulang'
                'Catatan'
            ]);

            foreach ($absensi as $item) {
                fputcsv($file, [
                    $item->pegawai->name,
                    $item->pegawai->nik,
                    $item->tanggal->format('d/m/Y'),
                    $item->jam_masuk_formatted ?? '-',
                    $item->jam_pulang_formatted ?? '-',
                    $this->getStatusDisplay($item->status_masuk),
                    $this->getStatusDisplay($item->status_pulang),
                    $item->catatan ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getStatusDisplay($status)
    {
        $statuses = [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'tidak hadir' => 'Tidak Hadir',
            'cepat' => 'Cepat Pulang',
            'normal' => 'Normal'
        ];

        return $statuses[$status] ?? $status;
    }

    public function print(Request $request)
    {
        // Ambil parameter filter
        $tanggal = $request->get('tanggal');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $pegawai_id = $request->get('pegawai_id');

        // Query data untuk print
        $absensi = Absensi::with('pegawai')
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal', $tanggal);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->when($pegawai_id, function ($query, $pegawai_id) {
                return $query->where('pegawai_id', $pegawai_id);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('pegawai_id')
            ->get();

        $statistik = $this->getStatistik($bulan, $tahun, $pegawai_id);

        return view('admin.rekap-absensi.print', compact(
            'absensi',
            'statistik',
            'tanggal',
            'bulan',
            'tahun'
        ));
    }
}
