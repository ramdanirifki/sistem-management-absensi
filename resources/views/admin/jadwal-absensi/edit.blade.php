@extends('layouts.admin')

@section('title', 'Edit Jadwal Absensi')

@section('admin-content')
  <div class="container mx-auto max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-slate-800">Edit Jadwal Absensi</h2>
      <p class="text-slate-600">Perbarui informasi jadwal absensi</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow p-6">
      <form action="{{ route('admin.jadwal-absensi.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nama Jadwal -->
          <div class="space-y-2">
            <label for="nama_jadwal" class="block text-sm font-medium text-gray-700">
              Nama Jadwal <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama_jadwal" name="nama_jadwal"
              value="{{ old('nama_jadwal', $jadwal->nama_jadwal) }}" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('nama_jadwal')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Kode Jadwal -->
          <div class="space-y-2">
            <label for="kode_jadwal" class="block text-sm font-medium text-gray-700">
              Kode Jadwal <span class="text-red-500">*</span>
            </label>
            <input type="text" id="kode_jadwal" name="kode_jadwal"
              value="{{ old('kode_jadwal', $jadwal->kode_jadwal) }}" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition uppercase">
            @error('kode_jadwal')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jam Masuk -->
          <div class="space-y-2">
            <label for="jam_masuk" class="block text-sm font-medium text-gray-700">
              Jam Masuk <span class="text-red-500">*</span>
            </label>
            <input type="time" id="jam_masuk" name="jam_masuk"
              value="{{ old('jam_masuk', date('H:i', strtotime($jadwal->jam_masuk))) }}" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('jam_masuk')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jam Pulang -->
          <div class="space-y-2">
            <label for="jam_pulang" class="block text-sm font-medium text-gray-700">
              Jam Pulang <span class="text-red-500">*</span>
            </label>
            <input type="time" id="jam_pulang" name="jam_pulang"
              value="{{ old('jam_pulang', date('H:i', strtotime($jadwal->jam_pulang))) }}" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('jam_pulang')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Toleransi Keterlambatan -->
          <div class="space-y-2">
            <label for="toleransi_keterlambatan" class="block text-sm font-medium text-gray-700">
              Toleransi Keterlambatan (menit) <span class="text-red-500">*</span>
            </label>
            <input type="number" id="toleransi_keterlambatan" name="toleransi_keterlambatan"
              value="{{ old('toleransi_keterlambatan', $jadwal->toleransi_keterlambatan) }}" min="0" max="120"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('toleransi_keterlambatan')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status Checkboxes -->
          <div class="space-y-4 col-span-1 md:col-span-2">
            <div class="flex items-center gap-4">
              <div class="flex items-center">
                <input type="checkbox" id="is_default" name="is_default" value="1"
                  {{ old('is_default', $jadwal->is_default) ? 'checked' : '' }}
                  class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="is_default" class="ml-2 text-sm text-gray-700">
                  Jadikan sebagai jadwal default
                </label>
              </div>
            </div>
          </div>

          <!-- Keterangan -->
          <div class="space-y-2 col-span-1 md:col-span-2">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">
              Keterangan (Opsional)
            </label>
            <textarea id="keterangan" name="keterangan" rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
            @error('keterangan')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
          <a href="{{ route('admin.jadwal-absensi.index') }}"
            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            Batal
          </a>
          <button type="submit"
            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Perbarui Jadwal
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
