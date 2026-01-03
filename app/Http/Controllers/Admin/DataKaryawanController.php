<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DataKaryawanController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $karyawan = User::where('role', 'karyawan')
      ->with('jabatan')
      ->orderBy('created_at', 'asc')
      ->paginate(request('per_page', 10));

    return view('admin.pegawai.index', [
      'karyawan' => $karyawan,
      'jabatans' => Jabatan::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.pegawai.create', [
      'jabatans' => Jabatan::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'nik' => 'required|string|max:20|unique:users',
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'nip' => 'required|string|max:50|unique:users',
      'jabatan_id' => 'required|exists:jabatans,id',
      'jenis_kelamin' => 'required|in:L,P',
      'tempat_lahir' => 'required|string|max:100',
      'tanggal_lahir' => 'required|date',
      'agama' => 'required|string|max:20',
      'alamat' => 'required|string',
      'no_telepon' => 'required|string|max:20',
      'tanggal_masuk' => 'required|date',
      'status' => 'required|in:aktif,nonaktif',
      'password' => 'required|string|min:8|confirmed',
      'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle foto upload
    if ($request->hasFile('foto')) {
      $fotoPath = $request->file('foto')->store('foto-profil', 'public');
      $validated['foto'] = $fotoPath;
    }

    $validated['password'] = Hash::make($validated['password']);
    $validated['role'] = 'karyawan';

    try {
      User::create($validated);

      return redirect()->route('admin.pegawai.index')
        ->with('success', 'Data pegawai berhasil ditambahkan!');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $user = User::where('role', 'karyawan')
      ->findOrFail($id);

    $jabatans = Jabatan::all();

    return view('admin.pegawai.edit', compact('user', 'jabatans'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $karyawan = User::findOrFail($id);

    $validated = $request->validate([
      'nik' => 'required|string|max:20|unique:users,nik,' . $id,
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $id,
      'nip' => 'required|string|max:50|unique:users,nip,' . $id,
      'jabatan_id' => 'required|exists:jabatans,id',
      'jenis_kelamin' => 'required|in:L,P',
      'tempat_lahir' => 'required|string|max:100',
      'tanggal_lahir' => 'required|date',
      'agama' => 'required|string|max:20',
      'alamat' => 'required|string',
      'no_telepon' => 'required|string|max:20',
      'tanggal_masuk' => 'required|date',
      'status' => 'required|in:aktif,nonaktif',
      'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Validasi foto secara terpisah jika ada
    if ($request->hasFile('foto')) {
      $request->validate([
        'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
      ]);

      // Hapus foto lama jika ada
      if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
        Storage::disk('public')->delete($karyawan->foto);
      }

      // Simpan foto baru
      $fotoPath = $request->file('foto')->store('foto-profil', 'public');
      $validated['foto'] = $fotoPath;
    }

    // Update password jika diisi
    if ($request->filled('password')) {
      $validated['password'] = Hash::make($validated['password']);
    } else {
      unset($validated['password']);
    }

    // SELALU set role sebagai karyawan
    $validated['role'] = 'karyawan';

    try {
      $karyawan->update($validated);

      return redirect()->route('admin.pegawai.index')
        ->with('success', 'Data karyawan berhasil diperbarui.');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $karyawan = User::findOrFail($id);

    // Hapus foto jika ada
    if ($karyawan->foto) {
      Storage::disk('public')->delete($karyawan->foto);
    }

    $karyawan->delete();

    return redirect()->route('admin.pegawai.index')
      ->with('success', 'Data karyawan berhasil dihapus.');
  }
}
