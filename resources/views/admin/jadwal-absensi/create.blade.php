@extends('layouts.admin')

@section('title', 'Tambah Jadwal Absensi')

@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Tambah Jadwal Absensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.lokasi-presensi.index') }}" class="text-slate-400 hover:text-indigo-600">Kelola Jadwal</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Tambah Baru</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.lokasi-presensi.index') }}"
        class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
    <div class="pb-6 border-b mt-6 mx-6">
      <h2 class="text-2xl font-bold text-slate-800">Tambah Jadwal Absensi Baru</h2>
      <p class="text-slate-600 text-sm mt-1">Isi form berikut untuk menambahkan jadwal absensi baru</p>
    </div>

    <form action="{{ route('admin.jadwal-absensi.store') }}" class="p-6" method="POST">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Jadwal -->
        <div class="space-y-2">
          <label for="nama_jadwal" class="block text-sm font-medium text-gray-700">
            Nama Jadwal <span class="text-red-500">*</span>
          </label>
          <input type="text" id="nama_jadwal" name="nama_jadwal" value="{{ old('nama_jadwal') }}" required
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
          <input type="text" id="kode_jadwal" name="kode_jadwal" value="{{ old('kode_jadwal') }}" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition uppercase"
            placeholder="SHIFT-A">
          @error('kode_jadwal')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Jam Masuk -->
        <div class="space-y-2">
          <label for="jam_masuk" class="block text-sm font-medium text-gray-700">
            Jam Masuk <span class="text-red-500">*</span>
          </label>
          <input type="time" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', '08:00') }}" required
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
          <input type="time" id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang', '17:00') }}" required
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
            value="{{ old('toleransi_keterlambatan', 15) }}" min="0" max="120" required
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
                {{ old('is_default') ? 'checked' : '' }}
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
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('keterangan') }}</textarea>
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
          <i class="fas fa-save"></i> Simpan Jadwal
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    // Auto-generate kode dari nama jadwal
    document.getElementById('nama_jadwal').addEventListener('input', function(e) {
      const kodeInput = document.getElementById('kode_jadwal');
      if (!kodeInput.value || kodeInput.value === kodeInput.defaultValue) {
        const kode = e.target.value
          .toUpperCase()
          .replace(/[^A-Z0-9]/g, '_')
          .substring(0, 10);
        kodeInput.value = kode;
      }
    });
  </script>
@endpush
