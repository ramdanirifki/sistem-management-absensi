@extends('layouts.karyawan')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')
@section('page-description', 'Kelola informasi dan keamanan akun Anda')

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="space-y-6">
      <!-- Profile Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-start gap-6">
          <!-- Foto Profil (Read-only) -->
          <div class="flex flex-col items-center">
            <div class="relative">
              <div class="w-32 h-32 rounded-xl bg-indigo-100 border-4 border-white shadow-lg overflow-hidden">
                @if ($pegawai->foto)
                  <img src="{{ Storage::url($pegawai->foto) }}" alt="{{ $pegawai->name }}"
                    class="w-full h-full object-cover">
                @else
                  <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-user text-indigo-600 text-4xl"></i>
                  </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Informasi Profil (Read-only) -->
          <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
              <div>
                <h3 class="text-xl font-bold text-slate-800">{{ $pegawai->name }}</h3>
                <p class="text-slate-600">{{ $pegawai->jabatan->nama ?? 'Karyawan' }}</p>
              </div>
              <div class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium">
                <i class="fas fa-circle text-xs mr-1"></i> Aktif
              </div>
            </div>

            <!-- Informasi Profil (Tampilan saja, tidak bisa diedit) -->
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                  <div class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700">
                    {{ $pegawai->name }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                  <div class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700">
                    {{ $pegawai->email }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
                  <div class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700">
                    {{ $pegawai->no_telepon ?? '-' }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-2">NIK / ID Pegawai</label>
                  <div class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700">
                    {{ $pegawai->nik ?? $pegawai->id }}
                  </div>
                </div>

                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                  <div
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700 min-h-[6rem]">
                    {{ $pegawai->alamat ?? '-' }}
                  </div>
                </div>
              </div>

              <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                  <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                  <div>
                    <p class="text-sm font-medium text-blue-800">Informasi</p>
                    <p class="text-sm text-blue-700 mt-1">
                      Untuk mengubah data pribadi (nama, email, telepon, alamat, foto), silakan hubungi administrator.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistik Card -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Total Kehadiran</p>
              <h3 class="text-2xl font-bold text-slate-800 mt-2">24</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
              <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
          </div>
          <p class="text-xs text-slate-500 mt-2">Bulan ini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Izin Disetujui</p>
              <h3 class="text-2xl font-bold text-slate-800 mt-2">3</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
              <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
            </div>
          </div>
          <p class="text-xs text-slate-500 mt-2">Tahun ini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Bergabung Sejak</p>
              <h3 class="text-2xl font-bold text-slate-800 mt-2">
                {{ \Carbon\Carbon::parse($pegawai->created_at)->format('Y') }}
              </h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
              <i class="fas fa-clock text-purple-600 text-xl"></i>
            </div>
          </div>
          <p class="text-xs text-slate-500 mt-2">{{ \Carbon\Carbon::parse($pegawai->created_at)->format('d F Y') }}</p>
        </div>
      </div>

      <!-- Keamanan Akun Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-lg font-semibold text-slate-800">Keamanan Akun</h3>
            <p class="text-sm text-slate-600">Ubah password untuk keamanan akun Anda</p>
          </div>
          <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
            <i class="fas fa-shield-alt text-red-600 text-xl"></i>
          </div>
        </div>

        <form action="{{ url('karyawan/profil/password') }}" method="POST" id="passwordForm">
          @csrf
          @method('PUT')

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Password Lama</label>
              <div class="relative">
                <input type="password" name="password_lama" id="password_lama" required
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10">
                <button type="button" onclick="togglePassword('password_lama')"
                  class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              @error('password_lama')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                <div class="relative">
                  <input type="password" name="password_baru" id="password_baru" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10">
                  <button type="button" onclick="togglePassword('password_baru')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                @error('password_baru')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                  <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10">
                  <button type="button" onclick="togglePassword('password_baru_confirmation')"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
              <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                <div>
                  <p class="text-sm font-medium text-yellow-800 mb-1">Tips Keamanan Password</p>
                  <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                    <li>Gunakan minimal 8 karakter</li>
                    <li>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                    <li>Jangan gunakan password yang mudah ditebak</li>
                    <li>Jangan gunakan ulang password lama</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="flex justify-end">
              <button type="submit"
                class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm flex items-center gap-2">
                <i class="fas fa-key"></i>
                Ubah Password
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Informasi Akun Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Akun</h3>
        <div class="space-y-4">
          <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div>
              <p class="text-sm font-medium text-slate-700">Role / Jabatan</p>
              <p class="text-slate-600">{{ $pegawai->jabatan->nama ?? 'Karyawan' }}</p>
            </div>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
              {{ $pegawai->role }}
            </span>
          </div>

          <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div>
              <p class="text-sm font-medium text-slate-700">ID Karyawan</p>
              <p class="text-slate-600">{{ $pegawai->id }}</p>
            </div>
            <i class="fas fa-id-card text-slate-400"></i>
          </div>

          <div class="flex items-center justify-between py-3">
            <div>
              <p class="text-sm font-medium text-slate-700">Status Akun</p>
              <p class="text-slate-600">Aktif</p>
            </div>
            <i class="fas fa-user-check text-emerald-500"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        window.togglePassword = function(inputId) {
          const input = document.getElementById(inputId);
          const icon = input.parentElement.querySelector('i');

          if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
          } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
          }
        };

        // HAPUS fungsi uploadFoto

        // Password form validation
        document.getElementById('passwordForm')?.addEventListener('submit', function(e) {
          const passwordLama = this.querySelector('input[name="password_lama"]').value;
          const passwordBaru = this.querySelector('input[name="password_baru"]').value;
          const passwordConfirm = this.querySelector('input[name="password_baru_confirmation"]').value;

          if (!passwordLama || !passwordBaru || !passwordConfirm) {
            e.preventDefault();
            alert('Semua field password harus diisi!');
            return false;
          }

          if (passwordBaru.length < 8) {
            e.preventDefault();
            alert('Password baru minimal 8 karakter!');
            return false;
          }

          if (passwordBaru !== passwordConfirm) {
            e.preventDefault();
            alert('Konfirmasi password tidak cocok!');
            return false;
          }

          // Show loading
          const submitBtn = this.querySelector('button[type="submit"]');
          const originalText = submitBtn.innerHTML;
          submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengubah...';
          submitBtn.disabled = true;

          // Re-enable after 5 seconds if something goes wrong
          setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
          }, 5000);
        });
      });
    </script>
  @endpush
@endsection
