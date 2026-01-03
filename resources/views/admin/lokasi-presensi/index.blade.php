@extends('layouts.admin')

@section('title', 'Lokasi Presensi - Admin Absensi')
@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Lokasi Presensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Kelola Lokasi</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.lokasi-presensi.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Lokasi
      </a>
    </div>
  </div>

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
        <input type="text" id="searchInput" placeholder="Cari nama lokasi..."
          class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-sm w-full md:w-64">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left whitespace-nowrap">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800 border-b border-slate-700">
          <tr>
            <th scope="col" class="px-4 py-4 text-center w-10">No.</th>
            <th scope="col" class="px-4 py-4">Nama Lokasi</th>
            <th scope="col" class="px-4 py-4">Alamat</th>
            <th scope="col" class="px-4 py-4">Koordinat</th>
            <th scope="col" class="px-4 py-4">Radius</th>
            <th scope="col" class="px-4 py-4">Status</th>
            <th scope="col" class="px-4 py-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-700 text-slate-300" id="tableBody">
          @forelse ($lokasis as $index => $lokasi)
            <tr class="hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>
              <td class="py-3 px-4">
                <div>
                  <p class="font-medium text-white">{{ $lokasi->nama }}</p>
                </div>
              </td>
              <td class="py-3 px-4 max-w-xs">
                <p class="truncate" title="{{ $lokasi->alamat }}">{{ Str::limit($lokasi->alamat, 50) }}</p>
              </td>
              <td class="py-3 px-4">
                <div class="text-xs">
                  <span class="text-blue-400">Lat: {{ number_format($lokasi->latitude, 6) }}</span><br>
                  <span class="text-green-400">Lng: {{ number_format($lokasi->longitude, 6) }}</span>
                </div>
              </td>
              <td class="py-3 px-4">
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-full text-xs font-bold">
                  {{ $lokasi->radius_meter }} m
                </span>
              </td>
              <td class="py-3 px-4">
                @if ($lokasi->aktif)
                  <span class="px-3 py-1 bg-emerald-600/20 text-emerald-400 rounded-full text-xs font-bold">
                    Aktif
                  </span>
                @else
                  <span class="px-3 py-1 bg-red-600/20 text-red-400 rounded-full text-xs font-bold">
                    Nonaktif
                  </span>
                @endif
              </td>
              <td class="py-3 px-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.lokasi-presensi.edit', $lokasi->id) }}"
                    class="bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white p-2 rounded transition"
                    title="Edit Lokasi">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.lokasi-presensi.destroy', $lokasi->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi {{ $lokasi->nama }}?')"
                      class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded transition"
                      title="Hapus Lokasi">
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
                    <i class="fas fa-map-marker-alt text-2xl text-slate-600"></i>
                  </div>
                  <div>
                    <div class="font-medium text-slate-400">Belum ada data lokasi presensi</div>
                    <div class="text-sm text-slate-500 mt-1">Mulai dengan menambahkan lokasi baru</div>
                  </div>
                  <a href="{{ route('admin.lokasi-presensi.create') }}"
                    class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Lokasi Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($lokasis->count() > 0)
      <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-between bg-slate-900">
        <span class="text-xs text-slate-500">
          Menampilkan <span
            class="font-medium text-slate-300">{{ $lokasis->firstItem() ?? 0 }}-{{ $lokasis->lastItem() ?? 0 }}</span>
          dari
          <span class="font-medium text-slate-300">{{ $lokasis->total() ?? 0 }}</span> lokasi
        </span>
        <div class="inline-flex gap-1">
          @if ($lokasis->onFirstPage())
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-left"></i>
            </span>
          @else
            <a href="{{ $lokasis->previousPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif

          @foreach (range(1, min(5, $lokasis->lastPage())) as $page)
            @if ($page == $lokasis->currentPage())
              <span
                class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 border border-indigo-600 rounded">{{ $page }}</span>
            @else
              <a href="{{ $lokasis->url($page) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $page }}</a>
            @endif
          @endforeach

          @if ($lokasis->hasMorePages())
            @if ($lokasis->lastPage() > 5)
              <span
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">...</span>
              <a href="{{ $lokasis->url($lokasis->lastPage()) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $lokasis->lastPage() }}</a>
            @endif
            <a href="{{ $lokasis->nextPageUrl() }}"
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
