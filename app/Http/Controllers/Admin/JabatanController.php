<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::withCount('pegawai')
            ->orderBy('id')
            ->paginate(request('per_page', 10));

        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('admin.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
        ]);

        $jabatan = Jabatan::findOrFail($id);

        // dd($request->all());

        try {
            $jabatan->update($validated);

            return redirect()->route('admin.jabatan.index')
                ->with('success', 'Jabatan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui jabatan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);

            // Cek apakah jabatan masih digunakan oleh pegawai
            if ($jabatan->pegawai()->count() > 0) {
                return redirect()->route('admin.jabatan.index')
                    ->with('error', 'Jabatan tidak dapat dihapus karena masih digunakan oleh ' . $jabatan->pegawai()->count() . ' pegawai!');
            }

            // Hapus data
            $deleted = $jabatan->delete();

            if (!$deleted) {
                return redirect()->route('admin.jabatan.index')
                    ->with('error', 'Gagal menghapus jabatan!');
            }

            return redirect()->route('admin.jabatan.index')
                ->with('success', 'Jabatan berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.jabatan.index')
                ->with('error', 'Jabatan tidak ditemukan!');
        }
    }
}
