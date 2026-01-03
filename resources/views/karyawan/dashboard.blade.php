<!-- resources/views/karyawan/dashboard.blade.php -->
@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang di portal karyawan')

@section('content')
  <div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h2 class="text-2xl font-bold mb-2">Selamat datang, {{ $pegawai->name }}! 👋</h2>
          <p class="text-indigo-100 opacity-90">
            {{ $pegawai->jabatan->nama ?? 'Karyawan' }} • {{ $pegawai->nik }}
          </p>
          <div class="mt-4 flex items-center gap-4">
            <div class="flex items-center gap-2">
              <i class="fas fa-calendar-day"></i>
              <span>{{ date('l, d F Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <i class="fas fa-clock"></i>
              <span id="currentTime">{{ date('H:i:s') }}</span>
            </div>
          </div>
        </div>
        <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30">
          @if ($pegawai->foto)
            <img src="{{ Storage::url($pegawai->foto) }}" alt="{{ $pegawai->name }}"
              class="w-16 h-16 rounded-full object-cover">
          @else
            <i class="fas fa-user text-3xl text-white"></i>
          @endif
        </div>
      </div>
    </div>

    <!-- Absensi Hari Ini -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Status Absensi -->
      <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Status Hari Ini</h3>
        <div class="space-y-4">
          @if ($absensiHariIni)
            <div class="flex items-center justify-between">
              <span class="text-slate-600">Jam Masuk</span>
              <span class="font-semibold {{ $absensiHariIni->jam_masuk ? 'text-emerald-600' : 'text-slate-400' }}">
                {{ $absensiHariIni->jam_masuk ? date('H:i', strtotime($absensiHariIni->jam_masuk)) : 'Belum absen' }}
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-600">Jam Pulang</span>
              <span class="font-semibold {{ $absensiHariIni->jam_pulang ? 'text-emerald-600' : 'text-slate-400' }}">
                {{ $absensiHariIni->jam_pulang ? date('H:i', strtotime($absensiHariIni->jam_pulang)) : 'Belum absen' }}
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-600">Status</span>
              <span
                class="px-3 py-1 rounded-full text-xs font-semibold 
                            {{ $absensiHariIni->status_masuk == 'hadir'
                                ? 'bg-emerald-100 text-emerald-800'
                                : ($absensiHariIni->status_masuk == 'terlambat'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-slate-100 text-slate-800') }}">
                {{ ucfirst($absensiHariIni->status_masuk) }}
              </span>
            </div>

            <div class="pt-4 border-t border-slate-200">
              <a href="{{ route('karyawan.absensi.index') }}"
                class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-calendar-check mr-2"></i>
                {{ $absensiHariIni->jam_pulang ? 'Lihat Detail' : 'Absensi Pulang' }}
              </a>
            </div>
          @else
            <div class="text-center py-8">
              <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-2xl text-slate-400"></i>
              </div>
              <p class="text-slate-600 mb-4">Belum melakukan absensi hari ini</p>
              <a href="{{ route('karyawan.absensi.index') }}"
                class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-fingerprint mr-2"></i>Absensi Sekarang
              </a>
            </div>
          @endif
        </div>
      </div>

      <!-- Statistik Bulan Ini -->
      <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Statistik Bulan Ini</h3>
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-emerald-50 rounded-lg p-4">
              <p class="text-sm text-emerald-600">Hadir</p>
              <p class="text-2xl font-bold text-emerald-700">{{ $statistikBulanIni->hadir ?? 0 }}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4">
              <p class="text-sm text-yellow-600">Terlambat</p>
              <p class="text-2xl font-bold text-yellow-700">{{ $statistikBulanIni->terlambat ?? 0 }}</p>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-red-50 rounded-lg p-4">
              <p class="text-sm text-red-600">Tidak Hadir</p>
              <p class="text-2xl font-bold text-red-700">{{ $statistikBulanIni->tidak_hadir ?? 0 }}</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
              <p class="text-sm text-blue-600">Total Hari</p>
              <p class="text-2xl font-bold text-blue-700">{{ $statistikBulanIni->total_hari ?? 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
          <a href="{{ route('karyawan.absensi.index') }}"
            class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition group">
            <div
              class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-600 transition">
              <i class="fas fa-fingerprint text-indigo-600 group-hover:text-white"></i>
            </div>
            <div class="flex-1">
              <p class="font-medium text-slate-800">Absensi</p>
              <p class="text-sm text-slate-500">Lakukan absensi masuk/pulang</p>
            </div>
            <i class="fas fa-chevron-right text-slate-400"></i>
          </a>

          <a href="{{ route('karyawan.absensi.riwayat') }}"
            class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition group">
            <div
              class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-600 transition">
              <i class="fas fa-history text-emerald-600 group-hover:text-white"></i>
            </div>
            <div class="flex-1">
              <p class="font-medium text-slate-800">Riwayat Absensi</p>
              <p class="text-sm text-slate-500">Lihat riwayat kehadiran</p>
            </div>
            <i class="fas fa-chevron-right text-slate-400"></i>
          </a>

          <a href="{{ route('karyawan.permohonan.create') }}"
            class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition group">
            <div
              class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-600 transition">
              <i class="fas fa-file-alt text-yellow-600 group-hover:text-white"></i>
            </div>
            <div class="flex-1">
              <p class="font-medium text-slate-800">Ajukan Permohonan</p>
              <p class="text-sm text-slate-500">Izin, sakit, atau cuti</p>
            </div>
            <i class="fas fa-chevron-right text-slate-400"></i>
          </a>

          <a href="{{ route('karyawan.profil.index') }}"
            class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 transition group">
            <div
              class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">
              <i class="fas fa-user-cog text-purple-600 group-hover:text-white"></i>
            </div>
            <div class="flex-1">
              <p class="font-medium text-slate-800">Profil Saya</p>
              <p class="text-sm text-slate-500">Kelola data pribadi</p>
            </div>
            <i class="fas fa-chevron-right text-slate-400"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Absensi Mingguan -->
    <div class="bg-white rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-slate-800">Riwayat 7 Hari Terakhir</h3>
        <a href="{{ route('karyawan.absensi.riwayat') }}"
          class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
          Lihat semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-slate-200">
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Tanggal</th>
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Hari</th>
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Jam Masuk</th>
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Jam Pulang</th>
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Status</th>
              <th class="py-3 px-4 text-left text-slate-600 font-medium">Keterangan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            @forelse($absensiMingguan as $absensi)
              <tr class="hover:bg-slate-50">
                <td class="py-3 px-4">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                <td class="py-3 px-4">{{ $absensi->tanggal->translatedFormat('l') }}</td>
                <td class="py-3 px-4">
                  @if ($absensi->jam_masuk)
                    <span class="font-medium">{{ date('H:i', strtotime($absensi->jam_masuk)) }}</span>
                  @else
                    <span class="text-slate-400">-</span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if ($absensi->jam_pulang)
                    <span class="font-medium">{{ date('H:i', strtotime($absensi->jam_pulang)) }}</span>
                  @else
                    <span class="text-slate-400">-</span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if ($absensi->status_masuk == 'hadir')
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                      Hadir
                    </span>
                  @elseif($absensi->status_masuk == 'terlambat')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                      Terlambat
                    </span>
                  @else
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                      Tidak Hadir
                    </span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if($absensi->catatan)
                    <span class="text-slate-500 text-xs truncate max-w-[150px]">{{ $absensi->catatan }}</span>
                  @else
                    <span class="text-slate-400 text-xs">-</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-slate-500">
                  <i class="fas fa-calendar-times text-3xl text-slate-300 mb-2 block"></i>
                  <p>Belum ada data absensi</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Update waktu real-time
    function updateTime() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      document.getElementById('currentTime').textContent = timeString;
    }

    setInterval(updateTime, 1000);

    // Auto-refresh dashboard setiap 30 detik
    setTimeout(() => {
      window.location.reload();
    }, 30000); // 30 detik
  </script>
@endsection
