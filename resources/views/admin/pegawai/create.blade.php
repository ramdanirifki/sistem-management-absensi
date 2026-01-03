@extends('layouts.admin')

@section('title', 'Tambah Pegawai Baru - Admin Absensi')

@section('page-title', 'Tambah Pegawai Baru')
@section('page-description', 'Form tambah data pegawai baru')

@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Tambah Pegawai Baru</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.pegawai.index') }}" class="text-slate-400 hover:text-indigo-600">Kelola Pegawai</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Tambah Baru</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.pegawai.index') }}"
        class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
    <div class="pb-6 border-b mt-6 mx-6">
      <h3 class="text-2xl font-bold text-slate-800">Form Tambah Pegawai</h3>
      <p class="text-slate-600 text-sm mt-1">Isi semua data dengan benar</p>
    </div>

    <form action="{{ route('admin.pegawai.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom 1 -->
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">NIK *</label>
            <input type="text" name="nik" value="{{ old('nik') }}" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan NIK">
            @error('nik')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan nama lengkap">
            @error('name')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan NIP">
            @error('nip')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan email">
            @error('email')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Jabatan *</label>
            <select name="jabatan_id" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
              <option value="">Pilih Jabatan</option>
              @foreach ($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                  {{ $jabatan->nama }}
                </option>
              @endforeach
            </select>
            @error('jabatan_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
            <div class="flex gap-4">
              <label class="flex items-center">
                <input type="radio" name="jenis_kelamin" value="L"
                  {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} class="mr-2 text-indigo-600 focus:ring-indigo-500">
                <span class="text-slate-700">Laki-laki</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="jenis_kelamin" value="P"
                  {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} class="mr-2 text-indigo-600 focus:ring-indigo-500">
                <span class="text-slate-700">Perempuan</span>
              </label>
            </div>
            @error('jenis_kelamin')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Kolom 2 -->
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan tempat lahir">
            @error('tempat_lahir')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
            @error('tanggal_lahir')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Agama</label>
            <select name="agama"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
              <option value="">Pilih Agama</option>
              <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
              <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
              <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
              <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
              <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
              <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
            </select>
            @error('agama')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
            <textarea name="alamat" rows="3"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
            @error('alamat')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
              placeholder="Masukkan nomor telepon">
            @error('no_telepon')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Kolom 3 -->
        <div class="space-y-4 md:col-span-2">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Masuk</label>
              <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
              @error('tanggal_masuk')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
              <select name="status"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
              </select>
              @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Password *</label>
              <input type="password" name="password" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
                placeholder="Masukkan password">
              @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password *</label>
              <input type="password" name="password_confirmation" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
                placeholder="Konfirmasi password">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
            <input type="file" name="foto" accept="image/*"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800">
            <p class="text-xs text-slate-500 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG</p>
            @error('foto')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end gap-3">
        <a href="{{ route('admin.pegawai.index') }}"
          class="px-6 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">
          Batal
        </a>
        <button type="submit"
          class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
          <i class="fas fa-save"></i> Simpan Data
        </button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Validasi form client-side
      const form = document.querySelector('form');
      if (form) {
        form.addEventListener('submit', function(e) {
          const password = document.querySelector('input[name="password"]').value;
          const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;

          if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
          }
        });
      }

      // Preview image jika upload foto
      const fotoInput = document.querySelector('input[name="foto"]');
      if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            if (file.size > 2 * 1024 * 1024) { // 2MB
              alert('Ukuran file terlalu besar! Maksimal 2MB.');
              fotoInput.value = '';
            }
          }
        });
      }
    });
  </script>
@endsection
