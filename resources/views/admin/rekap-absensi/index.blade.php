@extends('layouts.admin')

@section('title', 'Rekap Absensi - Admin Absensi')

@section('page-title', 'Rekap Absensi')
@section('page-description', 'Laporan kehadiran pegawai')

@section('admin-content')
  @if (session('success'))
    <div class="mb-6 p-4 bg-emerald-500 text-white rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-3">
        <i class="fas fa-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-white hover:text-emerald-200">
        <i class="fas fa-times"></i>
      </button>
    </div>
  @endif

  @if (session('error'))
    <div class="mb-6 p-4 bg-red-500 text-white rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-xl"></i>
        <span>{{ session('error') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-white hover:text-red-200">
        <i class="fas fa-times"></i>
      </button>
    </div>
  @endif

  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Rekap Absensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Laporan Kehadiran</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.rekap-absensi.export', request()->query()) }}"
        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-file-excel"></i> Export Excel
      </a>
      <a href="{{ route('admin.rekap-absensi.print', request()->query()) }}" target="_blank"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-print"></i> Cetak
      </a>
    </div>
  </div>

  <!-- Card Statistik -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Total Absensi</p>
          <p class="text-2xl font-bold text-slate-800">{{ $statistik->total_absensi ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
          <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Tepat Waktu</p>
          <p class="text-2xl font-bold text-emerald-600">{{ $statistik->total_hadir ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
          <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Terlambat</p>
          <p class="text-2xl font-bold text-yellow-600">{{ $statistik->total_terlambat ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
          <i class="fas fa-clock text-yellow-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Tidak Hadir</p>
          <p class="text-2xl font-bold text-red-600">{{ $statistik->total_tidak_hadir ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
          <i class="fas fa-times-circle text-red-600 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Filter Laporan</h3>
    <form method="GET" action="{{ route('admin.rekap-absensi.index') }}" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
          <input type="date" name="tanggal" value="{{ request('tanggal') }}"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
          <select name="bulan"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua Bulan</option>
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                {{ request('bulan', date('m')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
              </option>
            @endfor
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
          <select name="tahun"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            @for ($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
              <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>
                {{ $i }}
              </option>
            @endfor
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Pegawai</label>
          <select name="pegawai_id"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua Pegawai</option>
            @foreach ($pegawais as $pegawai)
              <option value="{{ $pegawai->id }}" {{ request('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                {{ $pegawai->name }} ({{ $pegawai->nik }})
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('admin.rekap-absensi.index') }}"
          class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">
          Reset Filter
        </a>
        <button type="submit"
          class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
          <i class="fas fa-filter"></i> Terapkan Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Table Section -->
  <div class="bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-700">
    <div
      class="p-5 border-b border-slate-700 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-900">
      <div class="flex items-center gap-2 text-slate-300 text-sm">
        <span>Tampilkan</span>
        <select id="perPageSelect"
          class="px-2 py-1 bg-slate-800 border border-slate-600 rounded text-slate-200 focus:outline-none">
          <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
          <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
          <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
          <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100</option>
        </select>
        <span>data</span>
      </div>

      <div class="flex items-center gap-2 w-full md:w-auto">
        <span class="text-slate-300 text-sm">Cari:</span>
        <input type="text" id="searchInput" placeholder="Cari nama pegawai..."
          class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-sm w-full md:w-64">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left whitespace-nowrap">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800 border-b border-slate-700">
          <tr>
            <th scope="col" class="px-4 py-4 text-center w-10">No.</th>
            <th scope="col" class="px-4 py-4">Pegawai</th>
            <th scope="col" class="px-4 py-4">Tanggal</th>
            <th scope="col" class="px-4 py-4">Jam Masuk</th>
            <th scope="col" class="px-4 py-4">Jam Pulang</th>
            <th scope="col" class="px-4 py-4">Status</th>
            <th scope="col" class="px-4 py-4">Catatan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-700 text-slate-300" id="tableBody">
          @forelse ($absensi as $index => $item)
            <tr class="hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-3 text-center text-slate-500">
                {{ ($absensi->currentPage() - 1) * $absensi->perPage() + $index + 1 }}
              </td>
              
              <td class="py-3 px-4">
                <div>
                  <p class="font-medium text-white">{{ $item->pegawai->name }}</p>
                  <p class="text-xs text-slate-400 mt-1">{{ $item->pegawai->nik }}</p>
                </div>
              </td>

              <td class="py-3 px-4">
                <span class="font-medium">
                  {{ $item->tanggal->format('d/m/Y') }}
                </span>
                <p class="text-xs text-slate-400">{{ $item->tanggal->format('l') }}</p>
              </td>

              <td class="py-3 px-4">
                @if ($item->jam_masuk)
                  <div class="flex items-center gap-2">
                    <i class="fas fa-sign-in-alt text-green-400"></i>
                    <span class="font-medium">{{ date('H:i', strtotime($item->jam_masuk)) }}</span>
                  </div>
                @else
                  <span class="text-slate-500">-</span>
                @endif
              </td>

              <td class="py-3 px-4">
                @if ($item->jam_pulang)
                  <div class="flex items-center gap-2">
                    <i class="fas fa-sign-out-alt text-red-400"></i>
                    <span class="font-medium">{{ date('H:i', strtotime($item->jam_pulang)) }}</span>
                  </div>
                @else
                  <span class="text-slate-500">-</span>
                @endif
              </td>

              <td class="py-3 px-4">
                <div class="flex flex-col gap-1">
                  @if ($item->status_masuk == 'hadir')
                    <span
                      class="inline-flex items-center gap-1 bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded text-xs border border-emerald-500/30">
                      <i class="fas fa-check-circle text-[10px]"></i>
                      Tepat Waktu
                    </span>
                  @elseif ($item->status_masuk == 'terlambat')
                    <span
                      class="inline-flex items-center gap-1 bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded text-xs border border-yellow-500/30">
                      <i class="fas fa-clock text-[10px]"></i>
                      Terlambat
                    </span>
                  @else
                    <span
                      class="inline-flex items-center gap-1 bg-red-500/20 text-red-400 px-2 py-1 rounded text-xs border border-red-500/30">
                      <i class="fas fa-times-circle text-[10px]"></i>
                      Tidak Hadir
                    </span>
                  @endif

                  @if ($item->status_pulang == 'cepat')
                    <span
                      class="inline-flex items-center gap-1 bg-orange-500/20 text-orange-400 px-2 py-1 rounded text-xs border border-orange-500/30">
                      <i class="fas fa-running text-[10px]"></i>
                      Cepat Pulang
                    </span>
                  @endif
                </div>
              </td>

              <td class="py-3 px-4">
                <span class="text-xs text-slate-400">
                  {{ $item->catatan ? Str::limit($item->catatan, 30) : '-' }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-3">
                  <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl text-slate-600"></i>
                  </div>
                  <div>
                    <div class="font-medium text-slate-400">Belum ada data absensi</div>
                    <div class="text-sm text-slate-500 mt-1">Tidak ada catatan absensi untuk filter yang dipilih</div>
                  </div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if ($absensi->count() > 0)
      <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-between bg-slate-900">
        <span class="text-xs text-slate-500">
          Menampilkan <span
            class="font-medium text-slate-300">{{ $absensi->firstItem() ?? 0 }}-{{ $absensi->lastItem() ?? 0 }}</span>
          dari
          <span class="font-medium text-slate-300">{{ $absensi->total() ?? 0 }}</span> data absensi
        </span>
        <div class="inline-flex gap-1">
          @if ($absensi->onFirstPage())
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-left"></i>
            </span>
          @else
            <a href="{{ $absensi->previousPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif

          @foreach (range(1, min(5, $absensi->lastPage())) as $page)
            @if ($page == $absensi->currentPage())
              <span
                class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 border border-indigo-600 rounded">{{ $page }}</span>
            @else
              <a href="{{ $absensi->url($page) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $page }}</a>
            @endif
          @endforeach

          @if ($absensi->hasMorePages())
            @if ($absensi->lastPage() > 5)
              <span
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">...</span>
              <a href="{{ $absensi->url($absensi->lastPage()) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $absensi->lastPage() }}</a>
            @endif
            <a href="{{ $absensi->nextPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-right"></i>
            </a>
          @else
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-right"></i>
            </span>
          @endif
        </div>
      </div>
    @endif
  </div>

  <div class="text-center text-xs text-slate-400 mt-8 mb-2">
    &copy; {{ date('Y') }} Sistem Absensi Online. All rights reserved.
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Fungsi untuk pencarian real-time
      const searchInput = document.getElementById('searchInput');
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();
          const rows = document.querySelectorAll('#tableBody tr');

          rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
          });
        });
      }

      // Fungsi untuk filter jumlah data per halaman
      const pageSizeSelect = document.getElementById('perPageSelect');
      if (pageSizeSelect) {
        pageSizeSelect.addEventListener('change', function() {
          const perPage = this.value;
          const currentUrl = window.location.href;
          const url = new URL(currentUrl);
          url.searchParams.set('per_page', perPage);
          window.location.href = url.toString();
        });
      }

      // Auto-submit filter bulan/tahun
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
