<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalAbsensiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);

    $jadwals = JadwalAbsensi::orderBy('is_default', 'desc')
      ->orderBy('nama_jadwal')
      ->paginate($perPage)
      ->withQueryString();

    return view('admin.jadwal-absensi.index', compact('jadwals'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.jadwal-absensi.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'nama_jadwal' => 'required|string|max:100',
      'kode_jadwal' => 'required|string|max:20|unique:jadwal_absensi',
      'jam_masuk' => 'required|date_format:H:i',
      'jam_pulang' => 'required|date_format:H:i|after:jam_masuk',
      'toleransi_keterlambatan' => 'required|integer|min:0|max:120',
      'keterangan' => 'nullable|string',
      'is_default' => 'nullable|boolean',
    ]);

    $validated['kode_jadwal'] = strtoupper($validated['kode_jadwal']);
    $validated['is_default'] = $validated['is_default'] ?? false;

    try {
      DB::transaction(function () use ($validated) {
        if ($validated['is_default']) {
          JadwalAbsensi::where('is_default', true)->update(['is_default' => false]);
        }

        JadwalAbsensi::create($validated);
      });

      return redirect()->route('admin.jadwal-absensi.index')
        ->with('success', 'Jadwal absensi berhasil ditambahkan.');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Gagal menambahkan jadwal: ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $jadwal = JadwalAbsensi::findOrFail($id);

    return view('admin.jadwal-absensi.edit', compact('jadwal'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $jadwal = JadwalAbsensi::findOrFail($id);

    $validated = $request->validate([
      'nama_jadwal' => 'required|string|max:100',
      'kode_jadwal' => 'required|string|max:20|unique:jadwal_absensi,kode_jadwal,' . $id,
      'jam_masuk' => 'required|date_format:H:i',
      'jam_pulang' => 'required|date_format:H:i|after:jam_masuk',
      'toleransi_keterlambatan' => 'required|integer|min:0|max:120',
      'keterangan' => 'nullable|string',
      'is_default' => 'boolean',
    ]);

    $validated['kode_jadwal'] = strtoupper($validated['kode_jadwal']);
    $validated['is_default'] = $validated['is_default'] ?? false;

    try {
      DB::transaction(function () use ($validated, $jadwal) {
        if ($validated['is_default'] && !$jadwal->is_default) {
          JadwalAbsensi::where('is_default', true)
            ->where('id', '!=', $jadwal->id)
            ->update(['is_default' => false]);
        }

        $jadwal->update($validated);
      });

      return redirect()->route('admin.jadwal-absensi.index')
        ->with('success', 'Jadwal absensi berhasil diperbarui.');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $jadwal = JadwalAbsensi::findOrFail($id);

    // Cek jika ini jadwal default
    if ($jadwal->is_default) {
      return redirect()->back()
        ->with('error', 'Tidak dapat menghapus jadwal default. Setel jadwal lain sebagai default terlebih dahulu.');
    }

    $jadwal->delete();

    return redirect()->route('admin.jadwal-absensi.index')
      ->with('success', 'Jadwal absensi berhasil dihapus.');
  }

  // Set default
  public function setDefault($id)
  {
    DB::transaction(function () use ($id) {
      JadwalAbsensi::where('is_default', true)->update(['is_default' => false]);

      $jadwal = JadwalAbsensi::findOrFail($id);
      $jadwal->update(['is_default' => true]);
    });

    return redirect()->route('admin.jadwal-absensi.index')
      ->with('success', 'Jadwal berhasil dijadikan default.');
  }
}
