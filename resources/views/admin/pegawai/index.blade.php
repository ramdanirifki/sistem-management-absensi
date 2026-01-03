@extends('layouts.admin')

@section('title', 'Data Pegawai - Admin Absensi')

@section('page-title', 'Data Pegawai')
@section('page-description', 'Kelola data pegawai/karyawan')

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
      <h2 class="text-3xl font-bold text-slate-800">Data Pegawai</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i> <span class="text-indigo-600 font-medium">Kelola
          Pegawai</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.pegawai.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Pegawai
      </a>
      <button
        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-file-excel"></i> Export
      </button>
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
        <input type="text" id="searchInput" placeholder="Cari nama pegawai..."
          class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-sm w-full md:w-64">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left whitespace-nowrap">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800 border-b border-slate-700">
          <tr>
            <th scope="col" class="px-4 py-4 text-center w-10">No.</th>
            <th scope="col" class="px-4 py-4 text-center">Foto</th>
            <th scope="col" class="px-4 py-4">NIP</th>
            <th scope="col" class="px-4 py-4">Nama Pegawai</th>
            <th scope="col" class="px-4 py-4">Tempat, Tanggal Lahir</th>
            <th scope="col" class="px-4 py-4 text-center">L/P</th>
            <th scope="col" class="px-4 py-4">Agama</th>
            <th scope="col" class="px-4 py-4">Alamat</th>
            <th scope="col" class="px-4 py-4">No. HP</th>
            <th scope="col" class="px-4 py-4 text-center sticky right-0 bg-slate-800">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-700 text-slate-300" id="tableBody">
          @forelse ($karyawan as $index => $item)
            <tr class="hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>
              <td class="px-4 py-3 text-center">
                @if ($item->foto)
                  <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto"
                    class="w-10 h-10 rounded-lg object-cover mx-auto border border-slate-600">
                @else
                  <div
                    class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold mx-auto border border-slate-600">
                    {{ strtoupper(substr($item->name, 0, 1)) }}
                  </div>
                @endif
              </td>
              <td class="px-4 py-3 text-slate-400">{{ $item->nip ?? '-' }}</td>
              <td class="px-4 py-3 font-medium text-white">{{ $item->name }}</td>
              <td class="px-4 py-3">
                @if ($item->tempat_lahir && $item->tanggal_lahir)
                  {{ $item->tempat_lahir }}, {{ date('d-m-Y', strtotime($item->tanggal_lahir)) }}
                @else
                  -
                @endif
              </td>
              <td class="px-4 py-3 text-center">{{ $item->jenis_kelamin ?? '-' }}</td>
              <td class="px-4 py-3">{{ $item->agama ?? '-' }}</td>
              <td class="px-4 py-3 truncate max-w-[150px]" title="{{ $item->alamat ?? '' }}">
                {{ $item->alamat ?? '-' }}
              </td>
              <td class="px-4 py-3">{{ $item->no_telepon ?? '-' }}</td>
              <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.pegawai.edit', $item->id) }}"
                    class="bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white p-2 rounded transition"
                    title="Edit Pegawai">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.pegawai.destroy', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                      class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded transition"
                      title="Hapus Pegawai">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="px-4 py-8 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-3">
                  <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-slate-600"></i>
                  </div>
                  <div>
                    <div class="font-medium text-slate-400">Belum ada data pegawai</div>
                    <div class="text-sm text-slate-500 mt-1">Mulai dengan menambahkan pegawai baru</div>
                  </div>
                  <a href="{{ route('admin.pegawai.create') }}"
                    class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Pegawai Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($karyawan->count() > 0)
      <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-between bg-slate-900">
        <span class="text-xs text-slate-500">
          Menampilkan <span
            class="font-medium text-slate-300">{{ $karyawan->firstItem() ?? 0 }}-{{ $karyawan->lastItem() ?? 0 }}</span>
          dari
          <span class="font-medium text-slate-300">{{ $karyawan->total() ?? 0 }}</span> data
        </span>
        <div class="inline-flex gap-1">
          @if ($karyawan->onFirstPage())
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-left"></i>
            </span>
          @else
            <a href="{{ $karyawan->previousPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif

          @foreach (range(1, min(5, $karyawan->lastPage())) as $page)
            @if ($page == $karyawan->currentPage())
              <span
                class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 border border-indigo-600 rounded">{{ $page }}</span>
            @else
              <a href="{{ $karyawan->url($page) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $page }}</a>
            @endif
          @endforeach

          @if ($karyawan->hasMorePages())
            @if ($karyawan->lastPage() > 5)
              <span
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">...</span>
              <a href="{{ $karyawan->url($karyawan->lastPage()) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $karyawan->lastPage() }}</a>
            @endif
            <a href="{{ $karyawan->nextPageUrl() }}"
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

  <!-- Tambahkan modal atau script jika diperlukan -->
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
