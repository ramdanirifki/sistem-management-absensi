@extends('layouts.admin')

@section('title', 'Dashboard Admin - Sistem Absensi')

@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan aktivitas sistem')

@section('admin-content')
  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Pegawai -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Total Pegawai</p>
          <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalPegawai }}</p>
          <p class="text-xs text-slate-400 mt-1">Aktif</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
          <i class="fas fa-users text-2xl text-blue-600"></i>
        </div>
      </div>
      <a href="{{ route('admin.pegawai.index') }}"
        class="mt-4 inline-flex items-center text-blue-600 text-sm font-medium hover:text-blue-800">
        Lihat semua <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>

    <!-- Absensi Hari Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Absensi Hari Ini</p>
          <p class="text-3xl font-bold text-slate-800 mt-2">{{ $absensiHariIni }}</p>
          <p class="text-xs text-slate-400 mt-1">{{ date('d M Y') }}</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center">
          <i class="fas fa-calendar-check text-2xl text-emerald-600"></i>
        </div>
      </div>
      <a href="{{ route('admin.rekap-absensi.index', ['tanggal' => date('Y-m-d')]) }}"
        class="mt-4 inline-flex items-center text-emerald-600 text-sm font-medium hover:text-emerald-800">
        Lihat detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>

    <!-- Total Jabatan -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Jabatan</p>
          <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalJabatan }}</p>
          <p class="text-xs text-slate-400 mt-1">Posisi kerja</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-violet-100 flex items-center justify-center">
          <i class="fas fa-briefcase text-2xl text-violet-600"></i>
        </div>
      </div>
      <a href="{{ route('admin.jabatan.index') }}"
        class="mt-4 inline-flex items-center text-violet-600 text-sm font-medium hover:text-violet-800">
        Kelola jabatan <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>

    <!-- Lokasi Presensi -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Lokasi Presensi</p>
          <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalLokasi }}</p>
          <p class="text-xs text-slate-400 mt-1">Titik absensi</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center">
          <i class="fas fa-map-marker-alt text-2xl text-orange-600"></i>
        </div>
      </div>
      <a href="{{ route('admin.lokasi-presensi.index') }}"
        class="mt-4 inline-flex items-center text-orange-600 text-sm font-medium hover:text-orange-800">
        Atur lokasi <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>
  </div>

  <!-- Main Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Statistik Kehadiran -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border border-slate-200">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Statistik Kehadiran</h3>
          <p class="text-sm text-slate-500">Rekap bulan {{ date('F Y') }}</p>
        </div>
        <div class="flex gap-2">
          <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
            <i class="fas fa-check-circle mr-1"></i> Hadir: {{ $hadirBulanIni }}
          </span>
          <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
            <i class="fas fa-clock mr-1"></i> Terlambat: {{ $terlambatBulanIni }}
          </span>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-slate-50 p-4 rounded-lg">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-500 flex items-center justify-center">
              <i class="fas fa-user-check text-white"></i>
            </div>
            <div>
              <p class="text-sm text-slate-500">Hadir</p>
              <p class="text-xl font-bold text-slate-800">{{ $hadirBulanIni }}</p>
            </div>
          </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-lg">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-yellow-500 flex items-center justify-center">
              <i class="fas fa-clock text-white"></i>
            </div>
            <div>
              <p class="text-sm text-slate-500">Terlambat</p>
              <p class="text-xl font-bold text-slate-800">{{ $terlambatBulanIni }}</p>
            </div>
          </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-lg">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-red-500 flex items-center justify-center">
              <i class="fas fa-user-times text-white"></i>
            </div>
            <div>
              <p class="text-sm text-slate-500">Tidak Hadir</p>
              <p class="text-xl font-bold text-slate-800">{{ $tidakHadirHariIni }}</p>
              <p class="text-xs text-slate-400">Hari ini</p>
            </div>
          </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-lg">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center">
              <i class="fas fa-percentage text-white"></i>
            </div>
            <div>
              <p class="text-sm text-slate-500">Kehadiran</p>
              <p class="text-xl font-bold text-slate-800">
                @if ($hadirBulanIni + $terlambatBulanIni > 0)
                  {{ number_format(($hadirBulanIni / ($hadirBulanIni + $terlambatBulanIni)) * 100, 1) }}%
                @else
                  0%
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Ringkasan Statistik -->
      <div class="bg-slate-50 rounded-lg p-6">
        <h4 class="font-medium text-slate-800 mb-4">Ringkasan 7 Hari Terakhir</h4>

        @if ($absensiMingguan->count() > 0)
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg border border-slate-200 text-center hover:shadow-sm transition-shadow">
              <p class="text-xs text-slate-500 mb-2">Total Kehadiran</p>
              <p class="text-2xl font-bold text-slate-800">{{ $absensiMingguan->sum('total') }}</p>
              <div class="mt-2 text-xs text-emerald-600">
                <i class="fas fa-users mr-1"></i> Seluruh pegawai
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 text-center hover:shadow-sm transition-shadow">
              <p class="text-xs text-slate-500 mb-2">Rata-rata/Hari</p>
              <p class="text-2xl font-bold text-slate-800">
                {{ number_format($absensiMingguan->avg('total'), 1) }}
              </p>
              <div class="mt-2 text-xs text-blue-600">
                <i class="fas fa-chart-line mr-1"></i> Per hari
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 text-center hover:shadow-sm transition-shadow">
              <p class="text-xs text-slate-500 mb-2">Hari Tertinggi</p>
              <p class="text-2xl font-bold text-slate-800">{{ $absensiMingguan->max('total') }}</p>
              <div class="mt-2 text-xs text-violet-600">
                <i class="fas fa-trophy mr-1"></i> Puncak kehadiran
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 text-center hover:shadow-sm transition-shadow">
              <p class="text-xs text-slate-500 mb-2">Trend</p>
              <p class="text-2xl font-bold text-slate-800">
                @if ($absensiMingguan->count() > 1)
                  @php
                    $first = $absensiMingguan->first()->total ?? 0;
                    $last = $absensiMingguan->last()->total ?? 0;
                    $trendIcon = $last > $first ? 'fa-arrow-up' : ($last < $first ? 'fa-arrow-down' : 'fa-minus');
                    $trendColor =
                        $last > $first ? 'text-emerald-600' : ($last < $first ? 'text-red-600' : 'text-slate-600');
                  @endphp
                  <span class="{{ $trendColor }}">
                    <i class="fas {{ $trendIcon }}"></i>
                  </span>
                @else
                  <span class="text-slate-600">-</span>
                @endif
              </p>
              <div class="mt-2 text-xs {{ $trendColor ?? 'text-slate-600' }}">
                @if (isset($trendColor) && $trendColor == 'text-emerald-600')
                  <i class="fas fa-chart-line mr-1"></i> Meningkat
                @elseif(isset($trendColor) && $trendColor == 'text-red-600')
                  <i class="fas fa-chart-line mr-1"></i> Menurun
                @else
                  <i class="fas fa-chart-line mr-1"></i> Stabil
                @endif
              </div>
            </div>
          </div>

          <!-- Daftar Hari -->
          <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                  <th class="py-3 px-4 text-left text-slate-600 font-medium">Hari/Tanggal</th>
                  <th class="py-3 px-4 text-left text-slate-600 font-medium">Jumlah Absensi</th>
                  <th class="py-3 px-4 text-left text-slate-600 font-medium">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($absensiMingguan as $data)
                  @php
                    $date = \Carbon\Carbon::parse($data->tanggal);
                    $isToday = $date->isToday();
                    $rowClass = $isToday ? 'bg-emerald-50' : ($loop->even ? 'bg-slate-50' : 'bg-white');
                  @endphp
                  <tr class="{{ $rowClass }} hover:bg-slate-100 transition-colors">
                    <td class="py-3 px-4">
                      <div class="flex items-center gap-3">
                        <div
                          class="w-8 h-8 rounded {{ $isToday ? 'bg-emerald-100' : 'bg-slate-100' }} flex items-center justify-center">
                          <span class="text-sm font-bold {{ $isToday ? 'text-emerald-600' : 'text-slate-600' }}">
                            {{ $date->format('d') }}
                          </span>
                        </div>
                        <div>
                          <p class="font-medium text-slate-800">{{ $date->translatedFormat('l') }}</p>
                          <p class="text-xs text-slate-500">{{ $date->format('d M Y') }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="py-3 px-4">
                      <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ $data->total }}</span>
                        <span class="text-xs text-slate-500">absensi</span>
                      </div>
                    </td>
                    <td class="py-3 px-4">
                      @if ($isToday)
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                          <i class="fas fa-circle mr-1 text-[8px]"></i> Hari Ini
                        </span>
                      @else
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                          <i class="fas fa-check mr-1 text-[8px]"></i> Selesai
                        </span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-8">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-calendar-times text-2xl text-slate-400"></i>
            </div>
            <p class="text-slate-500">Tidak ada data kehadiran 7 hari terakhir</p>
            <p class="text-sm text-slate-400 mt-1">Data akan muncul setelah ada aktivitas absensi</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Aktivitas Terbaru</h3>
          <p class="text-sm text-slate-500">5 absensi terkini</p>
        </div>
        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
          Today
        </span>
      </div>

      <div class="space-y-4">
        @forelse($absensiTerbaru as $absensi)
          <div class="flex items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors group">
            <div
              class="w-10 h-10 rounded-lg {{ $absensi->status_masuk == 'hadir' ? 'bg-emerald-100 text-emerald-600' : ($absensi->status_masuk == 'terlambat' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }} flex items-center justify-center group-hover:scale-105 transition-transform">
              @if ($absensi->status_masuk == 'hadir')
                <i class="fas fa-check"></i>
              @elseif($absensi->status_masuk == 'terlambat')
                <i class="fas fa-clock"></i>
              @else
                <i class="fas fa-times"></i>
              @endif
            </div>
            <div class="ml-3 flex-1">
              <p class="font-medium text-slate-800">{{ $absensi->pegawai->name ?? 'Unknown' }}</p>
              <div class="flex items-center gap-3 text-xs text-slate-500 mt-1">
                <span>
                  @if ($absensi->jam_masuk)
                    {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}
                  @else
                    -
                  @endif
                </span>
                <span
                  class="capitalize px-2 py-0.5 rounded {{ $absensi->status_masuk == 'hadir' ? 'bg-emerald-100 text-emerald-700' : ($absensi->status_masuk == 'terlambat' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                  {{ $absensi->status_masuk }}
                </span>
              </div>
            </div>
            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
              <i class="fas fa-chevron-right text-slate-400"></i>
            </div>
          </div>
        @empty
          <div class="text-center py-8">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-calendar-times text-2xl text-slate-400"></i>
            </div>
            <p class="text-slate-500">Belum ada aktivitas absensi</p>
          </div>
        @endforelse
      </div>

      <a href="{{ route('admin.rekap-absensi.index') }}"
        class="mt-6 w-full py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-lg text-sm font-medium flex items-center justify-center transition group">
        <i class="fas fa-eye mr-2"></i> Lihat Semua Aktivitas
        <i class="fas fa-arrow-right ml-2 text-xs opacity-0 group-hover:opacity-100 group-hover:ml-3 transition-all"></i>
      </a>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-6">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="{{ route('admin.pegawai.create') }}"
        class="p-4 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl transition-colors group hover:shadow-md">
        <div class="flex items-center gap-3">
          <div
            class="w-12 h-12 rounded-lg bg-blue-500 flex items-center justify-center group-hover:bg-blue-600 group-hover:scale-105 transition-all">
            <i class="fas fa-user-plus text-white text-xl"></i>
          </div>
          <div>
            <p class="font-medium text-slate-800">Tambah Pegawai</p>
            <p class="text-sm text-slate-500">Input data karyawan baru</p>
          </div>
        </div>
        <div class="mt-3 flex items-center text-blue-600 text-xs">
          <span>Mulai input data</span>
          <i class="fas fa-arrow-right ml-2 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
      </a>

      <a href="{{ route('admin.rekap-absensi.export', ['bulan' => date('m'), 'tahun' => date('Y')]) }}"
        class="p-4 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition-colors group hover:shadow-md">
        <div class="flex items-center gap-3">
          <div
            class="w-12 h-12 rounded-lg bg-emerald-500 flex items-center justify-center group-hover:bg-emerald-600 group-hover:scale-105 transition-all">
            <i class="fas fa-file-excel text-white text-xl"></i>
          </div>
          <div>
            <p class="font-medium text-slate-800">Export Laporan</p>
            <p class="text-sm text-slate-500">Bulan {{ date('F Y') }}</p>
          </div>
        </div>
        <div class="mt-3 flex items-center text-emerald-600 text-xs">
          <span>Download Excel</span>
          <i class="fas fa-download ml-2 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
      </a>

      <a href="{{ route('admin.ketidakhadiran.index') }}"
        class="p-4 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-xl transition-colors group hover:shadow-md">
        <div class="flex items-center gap-3">
          <div
            class="w-12 h-12 rounded-lg bg-orange-500 flex items-center justify-center group-hover:bg-orange-600 group-hover:scale-105 transition-all">
            <i class="fas fa-user-times text-white text-xl"></i>
          </div>
          <div>
            <p class="font-medium text-slate-800">Ketidakhadiran</p>
            <p class="text-sm text-slate-500">Kelola izin & cuti</p>
          </div>
        </div>
        <div class="mt-3 flex items-center text-orange-600 text-xs">
          <span>Lihat permohonan</span>
          <i class="fas fa-list ml-2 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
      </a>
    </div>
  </div>

  <div class="text-center text-xs text-slate-400 mt-8 mb-2">
    &copy; {{ date('Y') }} Sistem Absensi Online. All rights reserved.
  </div>
@endsection
