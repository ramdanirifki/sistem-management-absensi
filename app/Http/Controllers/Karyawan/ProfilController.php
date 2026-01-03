<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    /**
     * Menampilkan profil
     */
    public function index()
    {
        $user = Auth::user();
        $pegawai = User::with('jabatan')->findOrFail($user->id);

        return view('karyawan.profil.index', compact('pegawai'));
    }

    /**
     * Update password saja
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $pegawai = User::findOrFail($user->id);

        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama harus diisi',
            'password_baru.required' => 'Password baru harus diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek password lama
        if (!Hash::check($request->password_lama, $pegawai->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        // Update password
        $pegawai->password = Hash::make($request->password_baru);
        $pegawai->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
