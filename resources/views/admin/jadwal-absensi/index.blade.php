@extends('layouts.admin')

@section('title', 'Jadwal Absensi - Admin Absensi')

@section('page-title', 'Jadwal Absensi')
@section('page-description', 'Kelola jadwal kerja pegawai')

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
      <h2 class="text-3xl font-bold text-slate-800">Jadwal Absensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span><i class="fas fa-chevron-right text-xs"></i> <span class="text-indigo-600 font-medium">Kelola
          Jadwal</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.jadwal-absensi.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Jadwal
      </a>
    </div>
  </div>

  <div class="bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-700">
    <div
      class="p-5 border-b border-slate-700 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-900">
      <div class="flex items-center gap-2 text-slate-300 text-sm">
        <span>Tampilkan</span>
        <select id="perPageSelect"
          class="px-2 py-1 bg-slate-800 border border-slate-600 rounded text-slate-200 focus:outline-none">
          <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
          <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
          <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
        </select>
        <span>data</span>
      </div>

      <div class="flex items-center gap-2 w-full md:w-auto">
        <span class="text-slate-300 text-sm">Cari:</span>
        <input type="text" id="searchInput" placeholder="Cari nama jadwal..."
          class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-sm w-full md:w-64">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left whitespace-nowrap">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800 border-b border-slate-700">
          <tr>
            <th scope="col" class="px-4 py-4 text-center w-10">No.</th>
            <th scope="col" class="px-4 py-4">Kode</th>
            <th scope="col" class="px-4 py-4">Nama Jadwal</th>
            <th scope="col" class="px-4 py-4">Jam Kerja</th>
            <th scope="col" class="px-4 py-4">Toleransi</th>
            <th scope="col" class="px-4 py-4 text-center sticky right-0 bg-slate-800">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-700 text-slate-300" id="tableBody">
          @forelse ($jadwals as $index => $jadwal)
            <tr class="hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>

              <td class="py-3 px-4">
                <span class="font-mono bg-slate-800 text-indigo-300 px-2 py-1 rounded border border-slate-700">
                  {{ $jadwal->kode_jadwal }}
                </span>
              </td>

              <td class="py-3 px-4">
                <div>
                  <div class="flex items-center gap-2">
                    <p class="font-medium text-white">{{ $jadwal->nama_jadwal }}</p>
                    @if ($jadwal->is_default)
                      <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded border border-blue-500/30">
                        Default
                      </span>
                    @endif
                  </div>
                  @if ($jadwal->keterangan)
                    <p class="text-xs text-slate-400 mt-1">{{ Str::limit($jadwal->keterangan, 60) }}</p>
                  @endif
                </div>
              </td>

              <td class="py-3 px-4">
                <div class="flex flex-col">
                  <div class="flex items-center gap-2">
                    <span class="text-green-400">
                      <i class="fas fa-sign-in-alt text-xs"></i>
                      {{ date('H:i', strtotime($jadwal->jam_masuk)) }}
                    </span>
                    <span class="text-slate-500">→</span>
                    <span class="text-red-400">
                      <i class="fas fa-sign-out-alt text-xs"></i>
                      {{ date('H:i', strtotime($jadwal->jam_pulang)) }}
                    </span>
                  </div>
                  <div class="text-xs text-slate-500 mt-1">
                    {{ floor((strtotime($jadwal->jam_pulang) - strtotime($jadwal->jam_masuk)) / 3600) }} jam kerja
                  </div>
                </div>
              </td>

              <td class="py-3 px-4">
                <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded text-xs border border-yellow-500/30">
                  {{ $jadwal->toleransi_keterlambatan }} menit
                </span>
              </td>

              <td class="p-4 flex items-center justify-center gap-2">
                <div class="flex items-center gap-2">
                  <!-- Edit -->
                  <a href="{{ route('admin.jadwal-absensi.edit', $jadwal->id) }}"
                    class="bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white p-2 rounded transition"
                    title="Edit Jadwal">
                    <i class="fas fa-edit"></i>
                  </a>

                  <!-- Delete -->
                  <form action="{{ route('admin.jadwal-absensi.destroy', $jadwal->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal {{ $jadwal->nama_jadwal }}?')"
                      class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded transition"
                      title="Hapus Jadwal">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-3">
                  <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center">
                    <i class="fas fa-calendar-times text-2xl text-slate-600"></i>
                  </div>
                  <div>
                    <div class="font-medium text-slate-400">Belum ada data jadwal</div>
                    <div class="text-sm text-slate-500 mt-1">Mulai dengan menambahkan jadwal baru</div>
                  </div>
                  <a href="{{ route('admin.jadwal-absensi.create') }}"
                    class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Jadwal Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($jadwals->count() > 0)
      <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-between bg-slate-900">
        <span class="text-xs text-slate-500">
          Menampilkan <span
            class="font-medium text-slate-300">{{ $jadwals->firstItem() ?? 0 }}-{{ $jadwals->lastItem() ?? 0 }}</span>
          dari
          <span class="font-medium text-slate-300">{{ $jadwals->total() ?? 0 }}</span> jadwal
        </span>
        <div class="inline-flex gap-1">
          @if ($jadwals->onFirstPage())
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-left"></i>
            </span>
          @else
            <a href="{{ $jadwals->previousPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif

          @foreach (range(1, min(5, $jadwals->lastPage())) as $page)
            @if ($page == $jadwals->currentPage())
              <span
                class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 border border-indigo-600 rounded">{{ $page }}</span>
            @else
              <a href="{{ $jadwals->url($page) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $page }}</a>
            @endif
          @endforeach

          @if ($jadwals->hasMorePages())
            @if ($jadwals->lastPage() > 5)
              <span
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">...</span>
              <a href="{{ $jadwals->url($jadwals->lastPage()) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $jadwals->lastPage() }}</a>
            @endif
            <a href="{{ $jadwals->nextPageUrl() }}"
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
    });
  </script>
@endsection
