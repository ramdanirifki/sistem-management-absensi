@extends('layouts.karyawan')

@section('title', 'Permohonan')
@section('page-title', 'Daftar Permohonan')
@section('page-description', 'Kelola permohonan izin, sakit, dan cuti Anda')

@section('content')
  <div class="space-y-6">
    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600 font-medium">Total Permohonan</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $permohonans->total() }}</h3>
          </div>
          <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600 font-medium">Disetujui</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">
              {{ $permohonans->where('status', 'disetujui')->count() }}
            </h3>
          </div>
          <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
            <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600 font-medium">Menunggu</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">
              {{ $permohonans->where('status', 'pending')->count() }}
            </h3>
          </div>
          <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
            <i class="fas fa-clock text-amber-600 text-xl"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Header dengan Filter dan Button -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h2 class="text-lg font-semibold text-slate-800">Riwayat Permohonan</h2>
          <p class="text-sm text-slate-600 mt-1">Lihat dan kelola semua permohonan Anda</p>
        </div>

        <div class="flex items-center gap-3">
          <!-- Filter -->
          <div class="relative">
            <select id="filterStatus"
              class="appearance-none bg-white border border-slate-300 rounded-lg px-4 py-2.5 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
              <option value="">Semua Status</option>
              <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
              <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
              <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <i
              class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
          </div>

          <!-- Button Ajukan -->
          <a href="{{ route('karyawan.permohonan.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg transition shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Ajukan Permohonan</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Tabel Permohonan -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
      @if ($permohonans->isEmpty())
        <div class="text-center py-12">
          <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fas fa-inbox text-2xl text-slate-400"></i>
          </div>
          <h3 class="text-lg font-medium text-slate-700 mb-2">Belum ada permohonan</h3>
          <p class="text-slate-500 mb-6">Mulai ajukan permohonan pertama Anda</p>
          <a href="{{ route('karyawan.permohonan.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg transition shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Ajukan Permohonan</span>
          </a>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Jenis
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Tanggal
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Durasi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Diajukan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
              @foreach ($permohonans as $permohonan)
                <tr class="hover:bg-slate-50 transition">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="w-10 h-10 rounded-lg flex items-center justify-center mr-3
                                    {{ $permohonan->jenis == 'izin'
                                        ? 'bg-blue-100 text-blue-600'
                                        : ($permohonan->jenis == 'sakit'
                                            ? 'bg-red-100 text-red-600'
                                            : 'bg-purple-100 text-purple-600') }}">
                        <i
                          class="{{ $permohonan->jenis == 'izin'
                              ? 'fas fa-user-clock'
                              : ($permohonan->jenis == 'sakit'
                                  ? 'fas fa-heartbeat'
                                  : 'fas fa-umbrella-beach') }}"></i>
                      </div>
                      <div>
                        <span class="text-sm font-medium text-slate-800 capitalize">
                          {{ $permohonan->jenis }}
                        </span>
                        <p class="text-xs text-slate-500 truncate max-w-xs">{{ $permohonan->alasan }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-slate-900">
                      {{ \Carbon\Carbon::parse($permohonan->tanggal_mulai)->format('d M Y') }}
                    </div>
                    <div class="text-xs text-slate-500">
                      s/d {{ \Carbon\Carbon::parse($permohonan->tanggal_selesai)->format('d M Y') }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-800">
                      {{ $permohonan->durasi_hari }} hari
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @php
                      $statusColor =
                          [
                              'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                              'disetujui' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                              'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                          ][$permohonan->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                    @endphp
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColor }}">
                      @if ($permohonan->status == 'pending')
                        <i class="fas fa-clock mr-1.5 text-xs"></i>
                      @elseif($permohonan->status == 'disetujui')
                        <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                      @else
                        <i class="fas fa-times-circle mr-1.5 text-xs"></i>
                      @endif
                      {{ ucfirst($permohonan->status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                    {{ \Carbon\Carbon::parse($permohonan->created_at)->format('d M Y, H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center gap-2">
                      <a href="{{ route('karyawan.permohonan.show', $permohonan->id) }}"
                        class="text-indigo-600 hover:text-indigo-900 transition" title="Detail">
                        <i class="fas fa-eye"></i>
                      </a>

                      @if ($permohonan->status == 'pending')
                        <a href="{{ route('karyawan.permohonan.edit', $permohonan->id) }}"
                          class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>

                        <button onclick="confirmDelete({{ $permohonan->id }})"
                          class="text-red-600 hover:text-red-900 transition" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if ($permohonans->hasPages())
          <div class="px-6 py-4 border-t border-slate-200">
            {{ $permohonans->links() }}
          </div>
        @endif
      @endif
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-trash text-2xl text-red-600"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Permohonan</h3>
        <p class="text-slate-600">Apakah Anda yakin ingin menghapus permohonan ini?</p>
        <p class="text-sm text-slate-500 mt-2">Tindakan ini tidak dapat dibatalkan</p>
      </div>
      <div class="flex gap-3">
        <button onclick="hideDeleteModal()"
          class="flex-1 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
          Batal
        </button>
        <form id="deleteForm" method="POST" class="flex-1">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Ya, Hapus
          </button>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      // Filter status
      document.getElementById('filterStatus').addEventListener('change', function() {
        const status = this.value;
        let url = new URL(window.location.href);

        if (status) {
          url.searchParams.set('status', status);
        } else {
          url.searchParams.delete('status');
        }

        window.location.href = url.toString();
      });

      // Delete functions
      function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/karyawan/permohonan/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
      }

      function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
      }
    </script>
  @endpush
@endsection
