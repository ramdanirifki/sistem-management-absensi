<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ketidakhadiran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KetidakhadiranController extends Controller
{
  public function index(Request $request)
  {
    $query = Ketidakhadiran::with(['user', 'disetujuiOleh'])
      ->orderBy('tanggal_mulai', 'desc')
      ->orderBy('created_at', 'desc');

    // Filter tanggal
    if ($request->filled('bulan')) {
      $query->whereMonth('tanggal_mulai', $request->bulan);
    }

    if ($request->filled('tahun')) {
      $query->whereYear('tanggal_mulai', $request->tahun);
    }

    if ($request->filled('user_id')) {
      $query->where('user_id', $request->user_id);
    }

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('jenis')) {
      $query->where('jenis', $request->jenis);
    }

    $ketidakhadiran = $query->paginate($request->per_page ?? 20);

    $statistik = [
      'total' => Ketidakhadiran::count(),
      'disetujui' => Ketidakhadiran::where('status', 'disetujui')->count(),
      'pending' => Ketidakhadiran::where('status', 'pending')->count(),
      'ditolak' => Ketidakhadiran::where('status', 'ditolak')->count(),
      'cuti' => Ketidakhadiran::where('jenis', 'cuti')->count(),
      'izin' => Ketidakhadiran::where('jenis', 'izin')->count(),
      'sakit' => Ketidakhadiran::where('jenis', 'sakit')->count(),
    ];

    // Ubah dari Pegawai ke User
    $users = User::where('role', '!=', 'admin')
      ->orderBy('name')
      ->get();

    return view('admin.ketidakhadiran.index', compact(
      'ketidakhadiran',
      'statistik',
      'users'
    ));
  }

  public function create()
  {
    // Ubah dari Pegawai ke User
    $users = User::where('role', '!=', 'admin')
      ->orderBy('name')
      ->get();

    return view('admin.ketidakhadiran.create', compact('users'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required|exists:users,id',
      'jenis' => 'required|in:cuti,izin,sakit',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
      'alasan' => 'required|string|max:500',
      'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'status' => 'nullable|in:pending,disetujui,ditolak'
    ]);

    DB::beginTransaction();
    try {
      $data = $validated;
      $data['durasi_hari'] = \Carbon\Carbon::parse($validated['tanggal_mulai'])
        ->diffInDays(\Carbon\Carbon::parse($validated['tanggal_selesai'])) + 1;

      if ($request->hasFile('bukti')) {
        $buktiPath = $request->file('bukti')->store('permohonan/' . date('Y/m'), 'public');
        $data['bukti'] = $buktiPath;
      }

      $data['status'] = $data['status'] ?? 'pending';

      Ketidakhadiran::create($data);

      DB::commit();
      return redirect()->route('admin.ketidakhadiran.index')
        ->with('success', 'Ketidakhadiran berhasil ditambahkan');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
  }

  public function edit(Ketidakhadiran $ketidakhadiran)
  {
    return view('admin.ketidakhadiran.edit', compact('ketidakhadiran'));
  }

  public function update(Request $request, Ketidakhadiran $ketidakhadiran)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,disetujui,ditolak',
      'catatan_admin' => 'nullable|string|max:500'
    ]);

    if ($validated['status'] == 'disetujui') {
      $validated['disetujui_oleh'] = auth()->id();
      $validated['disetujui_pada'] = now();
    } else {
      $validated['disetujui_oleh'] = null;
      $validated['disetujui_pada'] = null;
    }

    $ketidakhadiran->update($validated);

    return redirect()->route('admin.ketidakhadiran.index')
      ->with('success', 'Status ketidakhadiran berhasil diperbarui');
  }

  public function destroy(Ketidakhadiran $ketidakhadiran)
  {
    DB::beginTransaction();
    try {
      // Hapus file bukti jika ada
      if ($ketidakhadiran->bukti && Storage::disk('public')->exists($ketidakhadiran->bukti)) {
        Storage::disk('public')->delete($ketidakhadiran->bukti);
      }

      $ketidakhadiran->delete();

      DB::commit();
      return redirect()->route('admin.ketidakhadiran.index')
        ->with('success', 'Ketidakhadiran berhasil dihapus');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
  }

  public function approve(Request $request, Ketidakhadiran $ketidakhadiran)
  {
    $request->validate([
      'catatan_admin' => 'nullable|string|max:500',
    ]);

    $ketidakhadiran->update([
      'status' => 'disetujui',
      'catatan_admin' => $request->catatan_admin,
      'disetujui_oleh' => auth()->id(),
      'disetujui_pada' => now()
    ]);

    return redirect()->route('admin.ketidakhadiran.index')
      ->with('success', 'Ketidakhadiran berhasil disetujui!');
  }

  public function reject(Request $request, Ketidakhadiran $ketidakhadiran)
  {
    $request->validate([
      'catatan_admin' => 'required|string|max:500'
    ]);

    $ketidakhadiran->update([
      'status' => 'ditolak',
      'catatan_admin' => $request->catatan_admin,
      'disetujui_oleh' => auth()->id(),
      'disetujui_pada' => now()
    ]);

    return redirect()->route('admin.ketidakhadiran.index')
      ->with('success', 'Ketidakhadiran berhasil ditolak!');
  }
}
