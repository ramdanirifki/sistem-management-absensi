@extends('layouts.karyawan')

@section('title', 'Riwayat Absensi')
@section('page-title', 'Riwayat Absensi')
@section('page-description', 'Lihat riwayat kehadiran Anda')

@section('content')
  <div class="space-y-6">
    <!-- Statistik dan Filter -->
    <div class="bg-white rounded-xl shadow p-6">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Riwayat Absensi</h3>
          <p class="text-slate-600 text-sm">Data kehadiran Anda</p>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('karyawan.absensi.riwayat') }}" class="flex gap-3">
          <div class="flex gap-2">
            <select name="bulan"
              class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
              @for ($i = 1; $i <= 12; $i++)
                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                  {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                  {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
              @endfor
            </select>

            <select name="tahun"
              class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
              @for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
              @endfor
            </select>
          </div>

          <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
            <i class="fas fa-filter mr-1"></i> Filter
          </button>

          <a href="{{ route('karyawan.absensi.riwayat') }}"
            class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition text-sm font-medium">
            Reset
          </a>
        </form>
      </div>

      <!-- Statistik -->
      @if ($statistikBulanIni)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-emerald-50 rounded-lg p-4 text-center">
            <p class="text-sm text-emerald-600 mb-1">Hadir</p>
            <p class="text-2xl font-bold text-emerald-700">{{ $statistikBulanIni->hadir ?? 0 }}</p>
          </div>
          <div class="bg-yellow-50 rounded-lg p-4 text-center">
            <p class="text-sm text-yellow-600 mb-1">Terlambat</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $statistikBulanIni->terlambat ?? 0 }}</p>
          </div>
          <div class="bg-red-50 rounded-lg p-4 text-center">
            <p class="text-sm text-red-600 mb-1">Tidak Hadir</p>
            <p class="text-2xl font-bold text-red-700">{{ $statistikBulanIni->tidak_hadir ?? 0 }}</p>
          </div>
          <div class="bg-blue-50 rounded-lg p-4 text-center">
            <p class="text-sm text-blue-600 mb-1">Total Hari</p>
            <p class="text-2xl font-bold text-blue-700">{{ $statistikBulanIni->total_hari ?? 0 }}</p>
          </div>
        </div>
      @endif

      <!-- Table -->
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
            @forelse($absensi as $item)
              <tr class="hover:bg-slate-50">
                <td class="py-3 px-4">
                  <span class="font-medium">{{ $item->tanggal->format('d/m/Y') }}</span>
                </td>
                <td class="py-3 px-4">
                  <span class="text-slate-600">{{ $item->tanggal->translatedFormat('l') }}</span>
                </td>
                <td class="py-3 px-4">
                  @if ($item->jam_masuk)
                    <div class="flex items-center gap-2">
                      <i class="fas fa-sign-in-alt text-emerald-500 text-xs"></i>
                      <span class="font-medium">{{ date('H:i', strtotime($item->jam_masuk)) }}</span>
                    </div>
                  @else
                    <span class="text-slate-400">-</span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if ($item->jam_pulang)
                    <div class="flex items-center gap-2">
                      <i class="fas fa-sign-out-alt text-red-500 text-xs"></i>
                      <span class="font-medium">{{ date('H:i', strtotime($item->jam_pulang)) }}</span>
                    </div>
                  @else
                    <span class="text-slate-400">-</span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  <div class="flex flex-col gap-1">
                    @if ($item->status_masuk == 'hadir')
                      <span
                        class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium text-center">
                        Hadir
                      </span>
                    @elseif($item->status_masuk == 'terlambat')
                      <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium text-center">
                        Terlambat
                      </span>
                    @else
                      <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium text-center">
                        Tidak Hadir
                      </span>
                    @endif

                    @if ($item->status_pulang == 'cepat')
                      <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium text-center">
                        Cepat Pulang
                      </span>
                    @endif
                  </div>
                </td>
                <td class="py-3 px-4">
                  @if ($item->catatan)
                    <span class="text-slate-600 text-xs" title="{{ $item->catatan }}">
                      {{ Str::limit($item->catatan, 30) }}
                    </span>
                  @else
                    <span class="text-slate-400 text-xs">-</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-slate-500">
                  <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-calendar-times text-3xl text-slate-300 mb-3"></i>
                    <p>Tidak ada data absensi untuk periode ini</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if ($absensi->hasPages())
        <div class="mt-6 pt-6 border-t border-slate-200 flex items-center justify-between">
          <div class="text-sm text-slate-600">
            Menampilkan {{ $absensi->firstItem() }} - {{ $absensi->lastItem() }} dari {{ $absensi->total() }} data
          </div>
          <div class="flex gap-1">
            @if ($absensi->onFirstPage())
              <span class="px-3 py-1.5 border border-slate-300 rounded text-slate-400 text-sm">
                <i class="fas fa-chevron-left"></i>
              </span>
            @else
              <a href="{{ $absensi->previousPageUrl() }}"
                class="px-3 py-1.5 border border-slate-300 rounded text-slate-700 hover:bg-slate-50 transition text-sm">
                <i class="fas fa-chevron-left"></i>
              </a>
            @endif

            @foreach (range(1, min(5, $absensi->lastPage())) as $page)
              @if ($page == $absensi->currentPage())
                <span class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm">
                  {{ $page }}
                </span>
              @else
                <a href="{{ $absensi->url($page) }}"
                  class="px-3 py-1.5 border border-slate-300 rounded text-slate-700 hover:bg-slate-50 transition text-sm">
                  {{ $page }}
                </a>
              @endif
            @endforeach

            @if ($absensi->hasMorePages())
              <a href="{{ $absensi->nextPageUrl() }}"
                class="px-3 py-1.5 border border-slate-300 rounded text-slate-700 hover:bg-slate-50 transition text-sm">
                <i class="fas fa-chevron-right"></i>
              </a>
            @else
              <span class="px-3 py-1.5 border border-slate-300 rounded text-slate-400 text-sm">
                <i class="fas fa-chevron-right"></i>
              </span>
            @endif
          </div>
        </div>
      @endif
    </div>

    <!-- Summary -->
    <div class="bg-white rounded-xl shadow p-6">
      <h3 class="text-lg font-bold text-slate-800 mb-4">Rangkuman</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h4 class="font-medium text-slate-700 mb-3">Persentase Kehadiran</h4>
          @if ($statistikBulanIni && $statistikBulanIni->total_hari > 0)
            @php
              $hadirPersen = ($statistikBulanIni->hadir / $statistikBulanIni->total_hari) * 100;
              $terlambatPersen = ($statistikBulanIni->terlambat / $statistikBulanIni->total_hari) * 100;
              $tidakHadirPersen = ($statistikBulanIni->tidak_hadir / $statistikBulanIni->total_hari) * 100;
            @endphp

            <div class="space-y-3">
              <div>
                <div class="flex justify-between text-sm mb-1">
                  <span class="text-emerald-600">Hadir</span>
                  <span class="font-medium">{{ number_format($hadirPersen, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                  <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $hadirPersen }}%"></div>
                </div>
              </div>

              <div>
                <div class="flex justify-between text-sm mb-1">
                  <span class="text-yellow-600">Terlambat</span>
                  <span class="font-medium">{{ number_format($terlambatPersen, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                  <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $terlambatPersen }}%"></div>
                </div>
              </div>

              <div>
                <div class="flex justify-between text-sm mb-1">
                  <span class="text-red-600">Tidak Hadir</span>
                  <span class="font-medium">{{ number_format($tidakHadirPersen, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                  <div class="bg-red-500 h-2 rounded-full" style="width: {{ $tidakHadirPersen }}%"></div>
                </div>
              </div>
            </div>
          @else
            <p class="text-slate-500 italic">Tidak ada data untuk dihitung</p>
          @endif
        </div>

        <div>
          <h4 class="font-medium text-slate-700 mb-3">Catatan Penting</h4>
          <ul class="space-y-2 text-sm text-slate-600">
            <li class="flex items-start gap-2">
              <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
              <span>Hadir tepat waktu atau dalam batas toleransi</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-clock text-yellow-500 mt-0.5"></i>
              <span>Terlambat jika masuk setelah jam toleransi</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
              <span>Tidak hadir jika tidak melakukan absensi masuk</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-running text-orange-500 mt-0.5"></i>
              <span>Cepat pulang jika absen pulang sebelum jam pulang</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto submit filter on change
      const bulanSelect = document.querySelector('select[name="bulan"]');
      const tahunSelect = document.querySelector('select[name="tahun"]');

      if (bulanSelect && tahunSelect) {
        bulanSelect.addEventListener('change', function() {
          this.form.submit();
        });

        tahunSelect.addEventListener('change', function() {
          this.form.submit();
        });
      }
    });
  </script>
@endsection
