<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'jabatan' => 'required',
            'departemen' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'role' => 'karyawan', // default role
            'tanggal_bergabung' => now(),
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }
}
