<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LokasiPresensiController extends Controller
{
    public function index()
    {
        $lokasis = LokasiPresensi::latest()
            ->paginate(request('per_page', 10));

        return view('admin.lokasi-presensi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('admin.lokasi-presensi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:1',
            'aktif' => 'nullable|boolean',
        ]);

        // Jika lokasi ini akan diaktifkan, nonaktifkan semua lokasi lain
        if (isset($validated['aktif']) && $validated['aktif'] == 1) {
            LokasiPresensi::where('aktif', 1)->update(['aktif' => 0]);
        } else {
            $validated['aktif'] = 0;
        }

        try {
            LokasiPresensi::create($validated);

            return redirect()->route('admin.lokasi-presensi.index')
                ->with('success', 'Lokasi presensi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan lokasi presensi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $lokasi = LokasiPresensi::findOrFail($id);
        return view('admin.lokasi-presensi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $lokasi = LokasiPresensi::findOrFail($id);

        // Validasi menggunakan validate() langsung
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:1',
            'aktif' => 'nullable|boolean',
        ]);

        // Jika checkbox tidak dicentang, set aktif = 0
        if (!isset($validated['aktif'])) {
            $validated['aktif'] = 0;
        }

        try {
            DB::transaction(function () use ($lokasi, $validated) {
                // Jika lokasi ini akan diaktifkan
                if ($validated['aktif'] == 1) {
                    // Nonaktifkan semua lokasi lain
                    LokasiPresensi::where('id', '!=', $lokasi->id)
                        ->where('aktif', 1)
                        ->update(['aktif' => 0]);
                }

                // Update lokasi saat ini
                $lokasi->update($validated);
            });

            return redirect()->route('admin.lokasi-presensi.index')
                ->with('success', 'Lokasi presensi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal update: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $lokasi = LokasiPresensi::findOrFail($id);

        try {
            $lokasi->delete();

            return redirect()->route('admin.lokasi-presensi.index')
                ->with('success', 'Lokasi presensi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
