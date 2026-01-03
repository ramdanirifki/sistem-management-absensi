<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Ketidakhadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Get filter status
        $status = request('status');

        $permohonans = Ketidakhadiran::where('user_id', $user->id)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('karyawan.permohonan.index', compact('permohonans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.permohonan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:cuti,izin,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        // Hitung durasi hari
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $durasiHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Validasi tanggal tidak boleh di masa lalu untuk tanggal mulai
        if ($tanggalMulai->lt(Carbon::today())) {
            return back()->withInput()->with('error', 'Tanggal mulai tidak boleh di masa lalu!');
        }

        // Cek overlap dengan permohonan lain yang statusnya pending atau disetujui
        $overlap = Ketidakhadiran::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->with('error', 'Sudah ada permohonan yang disetujui atau menunggu pada tanggal yang diminta!');
        }

        // Simpan bukti jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('permohonan/' . date('Y/m'), 'public');
        }

        // Buat permohonan
        Ketidakhadiran::create([
            'user_id' => $user->id,
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_hari' => $durasiHari,
            'alasan' => $request->alasan,
            'bukti' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('karyawan.permohonan.index')
            ->with('success', 'Permohonan berhasil diajukan! Menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();

        $permohonan = Ketidakhadiran::where('user_id', $user->id)
            ->findOrFail($id);

        return view('karyawan.permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $permohonan = Ketidakhadiran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        // Cek apakah masih bisa diedit (tidak melewati tanggal mulai)
        if (Carbon::parse($permohonan->tanggal_mulai)->lt(Carbon::today())) {
            return redirect()->route('karyawan.permohonan.index')
                ->with('error', 'Tidak dapat mengedit permohonan yang sudah lewat tanggal mulai!');
        }

        return view('karyawan.permohonan.edit', compact('permohonan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|in:cuti,izin,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        $permohonan = Ketidakhadiran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        // Cek apakah masih bisa diedit (tidak melewati tanggal mulai yang lama)
        if (Carbon::parse($permohonan->tanggal_mulai)->lt(Carbon::today())) {
            return redirect()->route('karyawan.permohonan.index')
                ->with('error', 'Tidak dapat mengedit permohonan yang sudah lewat tanggal mulai!');
        }

        // Validasi tanggal tidak boleh di masa lalu untuk tanggal mulai baru
        $tanggalMulaiBaru = Carbon::parse($request->tanggal_mulai);
        if ($tanggalMulaiBaru->lt(Carbon::today())) {
            return back()->withInput()->with('error', 'Tanggal mulai tidak boleh di masa lalu!');
        }

        // Hitung durasi hari
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $durasiHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Cek overlap dengan permohonan lain (kecuali dirinya sendiri)
        $overlap = Ketidakhadiran::where('user_id', $user->id)
            ->where('id', '!=', $id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->with('error', 'Sudah ada permohonan yang disetujui atau menunggu pada tanggal yang diminta!');
        }

        // Handle penghapusan bukti lama jika dicentang
        if ($request->has('hapus_bukti') && $request->hapus_bukti == '1') {
            if ($permohonan->bukti && Storage::disk('public')->exists($permohonan->bukti)) {
                Storage::disk('public')->delete($permohonan->bukti);
            }
            $permohonan->bukti = null;
        }

        // Update bukti jika ada file baru
        if ($request->hasFile('bukti')) {
            // Hapus bukti lama jika ada
            if ($permohonan->bukti && Storage::disk('public')->exists($permohonan->bukti)) {
                Storage::disk('public')->delete($permohonan->bukti);
            }
            $buktiPath = $request->file('bukti')->store('permohonan/' . date('Y/m'), 'public');
            $permohonan->bukti = $buktiPath;
        }

        // Update data permohonan
        $permohonan->update([
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_hari' => $durasiHari,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('karyawan.permohonan.index')
            ->with('success', 'Permohonan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $permohonan = Ketidakhadiran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        // Cek apakah masih bisa dihapus (tidak melewati tanggal mulai)
        if (Carbon::parse($permohonan->tanggal_mulai)->lt(Carbon::today())) {
            return redirect()->route('karyawan.permohonan.index')
                ->with('error', 'Tidak dapat menghapus permohonan yang sudah lewat tanggal mulai!');
        }

        // Hapus bukti jika ada
        if ($permohonan->bukti && Storage::disk('public')->exists($permohonan->bukti)) {
            Storage::disk('public')->delete($permohonan->bukti);
        }

        $permohonan->delete();

        return redirect()->route('karyawan.permohonan.index')
            ->with('success', 'Permohonan berhasil dibatalkan!');
    }
}
