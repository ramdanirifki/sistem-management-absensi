@extends('layouts.admin')

@section('title', 'Edit Data Pegawai')

@section('admin-content')
  <div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Data Pegawai</h2>
        <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
          <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
          <a href="{{ route('admin.pegawai.index') }}" class="text-slate-400 hover:text-indigo-600">Data Pegawai</a>
          <i class="fas fa-chevron-right text-xs"></i>
          <span class="text-indigo-600 font-medium">Edit Data</span>
        </div>
      </div>
      <a href="{{ route('admin.pegawai.index') }}"
        class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
      </a>
    </div>

    <!-- TAMPILKAN ERROR -->
    @if ($errors->any())
      <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
          <i class="fas fa-exclamation-triangle text-red-600"></i>
          <h4 class="font-medium text-red-800">Ada kesalahan:</h4>
        </div>
        <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- TAMPILKAN SUCCESS MESSAGE -->
    @if (session('success'))
      <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
        <div class="flex items-center gap-2">
          <i class="fas fa-check-circle text-emerald-600"></i>
          <p class="text-emerald-700">{{ session('success') }}</p>
        </div>
      </div>
    @endif

    @if (session('error'))
      <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center gap-2">
          <i class="fas fa-exclamation-circle text-red-600"></i>
          <p class="text-red-700">{{ session('error') }}</p>
        </div>
      </div>
    @endif

    <!-- Form Edit -->
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
      <form action="{{ route('admin.pegawai.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input hidden untuk role -->
        <input type="hidden" name="role" value="karyawan">

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom 1 -->
            <div class="space-y-6">
              <!-- NIK -->
              <div>
                <label for="nik" class="block text-sm font-medium text-slate-700 mb-1">
                  NIK <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                @error('nik')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- NIP -->
              <div>
                <label for="nip" class="block text-sm font-medium text-slate-700 mb-1">
                  NIP
                </label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <!-- Nama -->
              <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                  Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                @error('name')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                  Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Password (Optional) -->
              <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                  Password
                </label>
                <input type="password" id="password" name="password"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              {{-- Konfirmasi Password --}}
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-slate-800"
                  placeholder="Konfirmasi password baru">
              </div>

              <!-- Jabatan -->
              <div>
                <label for="jabatan_id" class="block text-sm font-medium text-slate-700 mb-1">
                  Jabatan <span class="text-red-500">*</span>
                </label>
                <select id="jabatan_id" name="jabatan_id"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                  <option value="">Pilih Jabatan</option>
                  @foreach ($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}"
                      {{ old('jabatan_id', $user->jabatan_id) == $jabatan->id ? 'selected' : '' }}>
                      {{ $jabatan->nama }}
                    </option>
                  @endforeach
                </select>
                @error('jabatan_id')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Kolom 2 -->
            <div class="space-y-6">
              <!-- No Telepon -->
              <div>
                <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1">
                  No. Telepon
                </label>
                <input type="text" id="no_telepon" name="no_telepon"
                  value="{{ old('no_telepon', $user->no_telepon) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <!-- Jenis Kelamin -->
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                  Jenis Kelamin
                </label>
                <div class="flex space-x-4">
                  <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="L"
                      {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'checked' : '' }}
                      class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2">Laki-laki</span>
                  </label>
                  <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="P"
                      {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'checked' : '' }}
                      class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2">Perempuan</span>
                  </label>
                </div>
              </div>

              <!-- Tempat Lahir -->
              <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-slate-700 mb-1">
                  Tempat Lahir
                </label>
                <input type="text" id="tempat_lahir" name="tempat_lahir"
                  value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <!-- Tanggal Lahir -->
              <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 mb-1">
                  Tanggal Lahir
                </label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                  value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <!-- Agama -->
              <div>
                <label for="agama" class="block text-sm font-medium text-slate-700 mb-1">
                  Agama
                </label>
                <select id="agama" name="agama"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="">Pilih Agama</option>
                  <option value="Islam" {{ old('agama', $user->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                  <option value="Kristen" {{ old('agama', $user->agama) == 'Kristen' ? 'selected' : '' }}>Kristen
                  </option>
                  <option value="Katolik" {{ old('agama', $user->agama) == 'Katolik' ? 'selected' : '' }}>Katolik
                  </option>
                  <option value="Hindu" {{ old('agama', $user->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                  <option value="Buddha" {{ old('agama', $user->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                  <option value="Konghucu" {{ old('agama', $user->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu
                  </option>
                </select>
              </div>

              <!-- Status -->
              <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">
                  Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                  <option value="">Pilih Status</option>
                  <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Alamat -->
          <div class="mt-6">
            <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1">
              Alamat
            </label>
            <textarea id="alamat" name="alamat" rows="3"
              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('alamat', $user->alamat) }}</textarea>
          </div>

          <!-- Tanggal Masuk -->
          <div class="mt-6">
            <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 mb-1">
              Tanggal Masuk
            </label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk"
              value="{{ old('tanggal_masuk', $user->tanggal_masuk) }}"
              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <!-- Foto -->
          <div class="mt-6">
            <label for="foto" class="block text-sm font-medium text-slate-700 mb-1">
              Foto Profil
            </label>
            @if ($user->foto)
              <div class="mb-3">
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                  class="w-32 h-32 object-cover rounded-lg border border-slate-300">
                <p class="text-sm text-slate-500 mt-1">Foto saat ini</p>
              </div>
            @endif
            <div id="foto-preview-container"></div>
            <input type="file" id="foto" name="foto" accept="image/*"
              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-sm text-slate-500 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG. Kosongkan jika tidak
              ingin mengubah foto.</p>
            @error('foto')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="mt-8 pt-6 border-t border-slate-200">
            <div class="flex justify-end space-x-3">
              <a href="{{ route('admin.pegawai.index') }}"
                class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                Batal
              </a>
              <button type="submit"
                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition flex items-center">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Preview foto sebelum upload
      const fotoInput = document.getElementById('foto');
      const previewContainer = document.getElementById('foto-preview-container');

      if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
              alert('Ukuran file terlalu besar! Maksimal 2MB.');
              this.value = '';
              return;
            }

            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
              alert('Format file tidak valid! Hanya JPEG dan PNG yang diperbolehkan.');
              this.value = '';
              return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
              // Hapus preview sebelumnya jika ada
              const existingPreview = document.querySelector('#foto-preview');
              if (existingPreview) {
                existingPreview.remove();
              }

              // Buat preview baru
              const preview = document.createElement('div');
              preview.id = 'foto-preview';
              preview.className = 'mb-3 mt-2';
              preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview Foto" 
                     class="w-32 h-32 object-cover rounded-lg border border-slate-300">
                <p class="text-sm text-slate-500 mt-1">Preview foto baru</p>
              `;
              previewContainer.prepend(preview);
            }
            reader.readAsDataURL(file);
          }
        });
      }
    });
  </script>
@endpush
