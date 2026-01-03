@extends('layouts.admin')

@section('title', 'Ketidakhadiran - Admin Absensi')
@section('page-title', 'Ketidakhadiran')
@section('page-description', 'Pengajuan cuti, izin, dan sakit')

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
      <h2 class="text-3xl font-bold text-slate-800">Ketidakhadiran</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Pengajuan Cuti/Izin/Sakit</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.ketidakhadiran.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Pengajuan
      </a>
    </div>
  </div>

  <!-- Card Statistik -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Total Pengajuan</p>
          <p class="text-2xl font-bold text-slate-800">{{ $statistik['total'] ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
          <i class="fas fa-file-alt text-blue-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Disetujui</p>
          <p class="text-2xl font-bold text-emerald-600">{{ $statistik['disetujui'] ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
          <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Pending</p>
          <p class="text-2xl font-bold text-yellow-600">{{ $statistik['pending'] ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
          <i class="fas fa-clock text-yellow-600 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 border border-slate-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Ditolak</p>
          <p class="text-2xl font-bold text-red-600">{{ $statistik['ditolak'] ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
          <i class="fas fa-times-circle text-red-600 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Filter Data</h3>
    <form method="GET" action="{{ route('admin.ketidakhadiran.index') }}" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
          <select name="bulan"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua Bulan</option>
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
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
          <label class="block text-sm font-medium text-slate-700 mb-2">User</label>
          <select name="user_id"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua User</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Jenis</label>
          <select name="jenis"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua Jenis</option>
            <option value="cuti" {{ request('jenis') == 'cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="izin" {{ request('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="sakit" {{ request('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
          <select name="status"
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('admin.ketidakhadiran.index') }}"
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
          <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
          <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
          <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
        </select>
        <span>data</span>
      </div>

      <div class="flex items-center gap-2 w-full md:w-auto">
        <span class="text-slate-300 text-sm">Cari:</span>
        <input type="text" id="searchInput" placeholder="Cari nama user atau alasan..."
          class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:outline-none text-sm w-full md:w-64">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left whitespace-nowrap">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800 border-b border-slate-700">
          <tr>
            <th scope="col" class="px-4 py-4 text-center w-10">No.</th>
            <th scope="col" class="px-4 py-4">User</th>
            <th scope="col" class="px-4 py-4">Jenis</th>
            <th scope="col" class="px-4 py-4">Tanggal</th>
            <th scope="col" class="px-4 py-4">Durasi</th>
            <th scope="col" class="px-4 py-4">Alasan</th>
            <th scope="col" class="px-4 py-4">Bukti</th>
            <th scope="col" class="px-4 py-4">Status</th>
            <th scope="col" class="px-4 py-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-700 text-slate-300" id="tableBody">
          @forelse ($ketidakhadiran as $index => $item)
            <tr class="hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>

              <td class="py-3 px-4">
                <div>
                  <p class="font-medium text-white">{{ $item->user->name }}</p>
                  <p class="text-xs text-slate-400 mt-1">{{ $item->user->email }}</p>
                </div>
              </td>

              <td class="py-3 px-4">
                @php
                  $jenisColors = [
                      'cuti' => 'bg-blue-600/20 text-blue-400',
                      'izin' => 'bg-purple-600/20 text-purple-400',
                      'sakit' => 'bg-red-600/20 text-red-400',
                  ];
                @endphp
                <span
                  class="px-3 py-1 {{ $jenisColors[$item->jenis] ?? 'bg-slate-600/20 text-slate-400' }} rounded-full text-xs font-bold">
                  <i
                    class="fas 
                                {{ $item->jenis == 'cuti' ? 'fa-umbrella-beach' : '' }}
                                {{ $item->jenis == 'izin' ? 'fa-file-signature' : '' }}
                                {{ $item->jenis == 'sakit' ? 'fa-heartbeat' : '' }} mr-1">
                  </i>
                  {{ ucfirst($item->jenis) }}
                </span>
              </td>

              <td class="py-3 px-4">
                <div class="text-xs">
                  <span class="font-medium">{{ $item->tanggal_mulai->format('d/m/Y') }}</span><br>
                  <span class="text-slate-400">s/d {{ $item->tanggal_selesai->format('d/m/Y') }}</span>
                </div>
              </td>

              <td class="py-3 px-4">
                <span class="px-3 py-1 bg-indigo-600/20 text-indigo-400 rounded-full text-xs font-bold">
                  {{ $item->durasi_hari }} hari
                </span>
              </td>

              <td class="py-3 px-4 max-w-xs">
                <p class="truncate" title="{{ $item->alasan }}">{{ Str::limit($item->alasan, 50) }}</p>
              </td>

              <td class="py-3 px-4">
                @if ($item->bukti)
                  <a href="{{ Storage::url($item->bukti) }}" target="_blank"
                    class="inline-flex items-center gap-1 text-indigo-400 hover:text-indigo-300 text-xs">
                    <i class="fas fa-paperclip"></i> Lihat
                  </a>
                @else
                  <span class="text-slate-500 text-xs">-</span>
                @endif
              </td>

              <td class="py-3 px-4">
                @php
                  $statusColors = [
                      'pending' => 'bg-yellow-600/20 text-yellow-400',
                      'disetujui' => 'bg-emerald-600/20 text-emerald-400',
                      'ditolak' => 'bg-red-600/20 text-red-400',
                  ];
                @endphp
                <span
                  class="px-3 py-1 {{ $statusColors[$item->status] ?? 'bg-slate-600/20 text-slate-400' }} rounded-full text-xs font-bold">
                  <i
                    class="fas 
                                {{ $item->status == 'pending' ? 'fa-clock' : '' }}
                                {{ $item->status == 'disetujui' ? 'fa-check-circle' : '' }}
                                {{ $item->status == 'ditolak' ? 'fa-times-circle' : '' }} mr-1">
                  </i>
                  {{ ucfirst($item->status) }}
                </span>
                @if ($item->disetujui_pada)
                  <p class="text-xs text-slate-500 mt-1">
                    {{ $item->disetujui_pada->format('d/m/Y H:i') }}
                  </p>
                @endif
              </td>

              <td class="py-3 px-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.ketidakhadiran.edit', $item->id) }}"
                    class="bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white p-2 rounded transition"
                    title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>

                  @if ($item->status == 'pending')
                    <!-- Ganti tombol approve dengan modal -->
                    <button type="button" onclick="showApproveModal({{ $item->id }})"
                      class="bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white p-2 rounded transition"
                      title="Setujui">
                      <i class="fas fa-check"></i>
                    </button>

                    <!-- Ganti tombol reject dengan modal -->
                    <button type="button" onclick="showRejectModal({{ $item->id }})"
                      class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded transition"
                      title="Tolak">
                      <i class="fas fa-times"></i>
                    </button>
                  @endif

                  <form action="{{ route('admin.ketidakhadiran.destroy', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus pengajuan ini?')"
                      class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded transition"
                      title="Hapus">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-4 py-8 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-3">
                  <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center">
                    <i class="fas fa-file-contract text-2xl text-slate-600"></i>
                  </div>
                  <div>
                    <div class="font-medium text-slate-400">Belum ada data ketidakhadiran</div>
                    <div class="text-sm text-slate-500 mt-1">Tidak ada pengajuan untuk filter yang dipilih
                    </div>
                  </div>
                  <a href="{{ route('admin.ketidakhadiran.create') }}"
                    class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Pengajuan Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($ketidakhadiran->count() > 0)
      <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-between bg-slate-900">
        <span class="text-xs text-slate-500">
          Menampilkan <span
            class="font-medium text-slate-300">{{ $ketidakhadiran->firstItem() ?? 0 }}-{{ $ketidakhadiran->lastItem() ?? 0 }}</span>
          dari
          <span class="font-medium text-slate-300">{{ $ketidakhadiran->total() ?? 0 }}</span> data
        </span>
        <div class="inline-flex gap-1">
          @if ($ketidakhadiran->onFirstPage())
            <span
              class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-800 border border-slate-700 rounded cursor-not-allowed">
              <i class="fas fa-chevron-left"></i>
            </span>
          @else
            <a href="{{ $ketidakhadiran->previousPageUrl() }}"
              class="px-2 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif

          @foreach (range(1, min(5, $ketidakhadiran->lastPage())) as $page)
            @if ($page == $ketidakhadiran->currentPage())
              <span
                class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 border border-indigo-600 rounded">{{ $page }}</span>
            @else
              <a href="{{ $ketidakhadiran->url($page) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $page }}</a>
            @endif
          @endforeach

          @if ($ketidakhadiran->hasMorePages())
            @if ($ketidakhadiran->lastPage() > 5)
              <span
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">...</span>
              <a href="{{ $ketidakhadiran->url($ketidakhadiran->lastPage()) }}"
                class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800 border border-slate-700 rounded hover:bg-slate-700 transition">{{ $ketidakhadiran->lastPage() }}</a>
            @endif
            <a href="{{ $ketidakhadiran->nextPageUrl() }}"
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

  <!-- Modal Setujui -->
  <div id="approveModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <form id="approveForm" method="POST" class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
      @csrf
      @method('PUT')
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-check text-2xl text-emerald-600"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Setujui Pengajuan</h3>
        <p class="text-slate-600">Tambahkan catatan persetujuan (opsional)</p>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Persetujuan (Opsional)</label>
        <textarea name="catatan_admin" rows="3"
          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
          placeholder="Masukkan catatan persetujuan (jika ada)..."></textarea>
        <p class="text-xs text-slate-500 mt-1">Catatan ini akan dilihat oleh karyawan</p>
      </div>

      <div class="flex gap-3">
        <button type="button" onclick="hideApproveModal()"
          class="flex-1 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
          Batal
        </button>
        <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
          Setujui Pengajuan
        </button>
      </div>
    </form>
  </div>

  <!-- Modal Tolak -->
  <div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <form id="rejectForm" method="POST" class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
      @csrf
      @method('PUT')
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-times text-2xl text-red-600"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Tolak Pengajuan</h3>
        <p class="text-slate-600">Berikan alasan penolakan</p>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Penolakan *</label>
        <textarea name="catatan_admin" rows="3" required
          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
          placeholder="Masukkan alasan penolakan..."></textarea>
      </div>

      <div class="flex gap-3">
        <button type="button" onclick="hideRejectModal()"
          class="flex-1 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
          Batal
        </button>
        <button type="submit" class="flex-1 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
          Tolak Pengajuan
        </button>
      </div>
    </form>
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

    // Modal functions
    function showApproveModal(id) {
      document.getElementById('approveForm').action = `/admin/ketidakhadiran/${id}/approve`;
      document.getElementById('approveModal').classList.remove('hidden');
    }

    function hideApproveModal() {
      document.getElementById('approveModal').classList.add('hidden');
    }

    function showRejectModal(id) {
      document.getElementById('rejectForm').action = `/admin/ketidakhadiran/${id}/reject`;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
      document.getElementById('rejectModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('approveModal')?.addEventListener('click', function(e) {
      if (e.target === this) {
        hideApproveModal();
      }
    });

    document.getElementById('rejectModal')?.addEventListener('click', function(e) {
      if (e.target === this) {
        hideRejectModal();
      }
    });
  </script>
@endsection
