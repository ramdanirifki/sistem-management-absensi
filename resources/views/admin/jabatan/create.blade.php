@extends('layouts.admin')

@section('title', 'Tambah Jabatan')
@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Tambah Jabatan Baru</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.jabatan.index') }}" class="text-slate-400 hover:text-indigo-600">Kelola Jabatan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Tambah Baru</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.jabatan.index') }}"
        class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto">
    <div class="pb-6 border-b mt-6 mx-6">
      <h2 class="text-2xl font-bold text-slate-800">Tambah Jabatan Baru</h2>
      <p class="text-slate-600 text-sm mt-1">Isi form berikut untuk menambahkan jabatan baru</p>
    </div>

    <form action="{{ route('admin.jabatan.store') }}" class="p-6" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Nama Jabatan *</label>
          <input type="text" name="nama" required
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            placeholder="Contoh: Direktur, Manager, Staff" required>
          @error('nama')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
          <textarea name="deskripsi" rows="3"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            placeholder="Deskripsi singkat tentang jabatan" required></textarea>
          @error('deskripsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Gaji Pokok (Rp) *</label>
            <input type="number" name="gaji_pokok" required min="0" step="1000"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: 5000000" required>
            @error('gaji_pokok')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Tunjangan (Rp)</label>
            <input type="number" name="tunjangan" min="0" step="1000"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: 1000000" required>
            @error('tunjangan')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.jabatan.index') }}"
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
