@extends('layouts.admin')

@section('title', 'Tambah Ketidakhadiran - Admin Absensi')

@section('page-title', 'Tambah Ketidakhadiran')
@section('page-description', 'Form pengajuan ketidakhadiran')

@section('admin-content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-lg font-bold text-slate-800 mb-6">Tambah Pengajuan Ketidakhadiran</h3>

      <form method="POST" action="{{ route('admin.ketidakhadiran.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
          <!-- User -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">User *</label>
            <select name="user_id" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
              <option value="">Pilih User</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->name }} ({{ $user->email }})
                </option>
              @endforeach
            </select>
            @error('user_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jenis -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Ketidakhadiran *</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-slate-50">
                <input type="radio" name="jenis" value="cuti" required {{ old('jenis') == 'cuti' ? 'checked' : '' }}
                  class="mr-3 text-indigo-600">
                <div>
                  <div class="font-medium text-slate-800">Cuti</div>
                  <div class="text-sm text-slate-500">Keperluan pribadi</div>
                </div>
              </label>

              <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-slate-50">
                <input type="radio" name="jenis" value="izin" required {{ old('jenis') == 'izin' ? 'checked' : '' }}
                  class="mr-3 text-indigo-600">
                <div>
                  <div class="font-medium text-slate-800">Izin</div>
                  <div class="text-sm text-slate-500">Keperluan mendadak</div>
                </div>
              </label>

              <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-slate-50">
                <input type="radio" name="jenis" value="sakit" required
                  {{ old('jenis') == 'sakit' ? 'checked' : '' }} class="mr-3 text-indigo-600">
                <div>
                  <div class="font-medium text-slate-800">Sakit</div>
                  <div class="text-sm text-slate-500">Kondisi kesehatan</div>
                </div>
              </label>
            </div>
            @error('jenis')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tanggal -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai *</label>
              <input type="date" name="tanggal_mulai" required value="{{ old('tanggal_mulai') }}"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
              @error('tanggal_mulai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai *</label>
              <input type="date" name="tanggal_selesai" required value="{{ old('tanggal_selesai') }}"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
              @error('tanggal_selesai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Alasan -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Alasan *</label>
            <textarea name="alasan" rows="4" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Jelaskan alasan ketidakhadiran...">{{ old('alasan') }}</textarea>
            @error('alasan')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Bukti -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Bukti (Opsional)</label>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG, PDF (maks. 2MB)</p>
            @error('bukti')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status (default: pending untuk create) -->
          <input type="hidden" name="status" value="pending">

          <!-- Tombol -->
          <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.ketidakhadiran.index') }}"
              class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">
              Batal
            </a>
            <button type="submit"
              class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
              <i class="fas fa-save"></i> Simpan Pengajuan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Validasi tanggal
    document.addEventListener('DOMContentLoaded', function() {
      const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]');
      const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]');

      if (tanggalMulai && tanggalSelesai) {
        tanggalMulai.addEventListener('change', function() {
          if (this.value) {
            tanggalSelesai.min = this.value;
          }
        });
      }
    });
  </script>
@endsection
