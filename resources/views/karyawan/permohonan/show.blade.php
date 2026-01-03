@extends('layouts.karyawan')

@section('title', 'Detail Permohonan')
@section('page-title', 'Detail Permohonan')
@section('page-description', 'Lihat detail lengkap permohonan Anda')

@section('content')
  <div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
      <a href="{{ route('karyawan.permohonan.index') }}" class="hover:text-indigo-600">
        Permohonan
      </a>
      <i class="fas fa-chevron-right text-xs"></i>
      <span class="text-indigo-600 font-medium">Detail</span>
    </div>

    <div class="space-y-6">
      <!-- Header Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div class="flex items-center gap-4">
            <div
              class="w-16 h-16 rounded-lg flex items-center justify-center 
                        {{ $permohonan->jenis == 'izin'
                            ? 'bg-blue-100 text-blue-600'
                            : ($permohonan->jenis == 'sakit'
                                ? 'bg-red-100 text-red-600'
                                : 'bg-purple-100 text-purple-600') }}">
              <i
                class="{{ $permohonan->jenis == 'izin'
                    ? 'fas fa-user-clock text-2xl'
                    : ($permohonan->jenis == 'sakit'
                        ? 'fas fa-heartbeat text-2xl'
                        : 'fas fa-umbrella-beach text-2xl') }}"></i>
            </div>
            <div>
              <h2 class="text-xl font-bold text-slate-800 capitalize">{{ $permohonan->jenis }}</h2>
              <p class="text-slate-600">ID: #{{ str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
          </div>

          <div>
            @php
              $statusColor =
                  [
                      'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                      'disetujui' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                      'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                  ][$permohonan->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $statusColor }}">
              @if ($permohonan->status == 'pending')
                <i class="fas fa-clock mr-1.5"></i>
              @elseif($permohonan->status == 'disetujui')
                <i class="fas fa-check-circle mr-1.5"></i>
              @else
                <i class="fas fa-times-circle mr-1.5"></i>
              @endif
              {{ ucfirst($permohonan->status) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Info Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Permohonan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-info-circle text-indigo-600"></i>
            Informasi Permohonan
          </h3>

          <div class="space-y-4">
            <div>
              <p class="text-sm text-slate-500">Tanggal Mulai</p>
              <p class="font-medium text-slate-800">
                {{ \Carbon\Carbon::parse($permohonan->tanggal_mulai)->format('d M Y') }}
              </p>
            </div>

            <div>
              <p class="text-sm text-slate-500">Tanggal Selesai</p>
              <p class="font-medium text-slate-800">
                {{ \Carbon\Carbon::parse($permohonan->tanggal_selesai)->format('d M Y') }}
              </p>
            </div>

            <div>
              <p class="text-sm text-slate-500">Durasi</p>
              <p class="font-medium text-slate-800">
                {{ $permohonan->durasi_hari }} hari
              </p>
            </div>

            <div>
              <p class="text-sm text-slate-500">Diajukan Pada</p>
              <p class="font-medium text-slate-800">
                {{ \Carbon\Carbon::parse($permohonan->created_at)->format('d M Y, H:i') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Alasan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-comment-alt text-indigo-600"></i>
            Alasan
          </h3>

          <div class="p-4 bg-slate-50 rounded-lg">
            <p class="text-slate-700 whitespace-pre-line">{{ $permohonan->alasan }}</p>
          </div>
        </div>
      </div>

      <!-- Catatan Admin jika ditolak -->
      @if ($permohonan->status == 'ditolak' && $permohonan->catatan_admin)
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-comment text-red-600"></i>
            Catatan Penolakan
          </h3>

          <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start gap-3">
              <i class="fas fa-info-circle text-red-500 mt-1"></i>
              <div>
                <p class="text-red-700 font-medium mb-1">Alasan Penolakan:</p>
                <p class="text-red-600 whitespace-pre-line">{{ $permohonan->catatan_admin }}</p>
                @if ($permohonan->disetujui_oleh && $permohonan->disetujui_pada)
                  <p class="text-xs text-red-500 mt-2">
                    Oleh: {{ $permohonan->disetujuiOleh->name ?? 'Admin' }}
                    • {{ \Carbon\Carbon::parse($permohonan->disetujui_pada)->format('d M Y, H:i') }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Catatan Admin jika disetujui -->
      @if ($permohonan->status == 'disetujui' && $permohonan->catatan_admin)
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-comment text-emerald-600"></i>
            Catatan Persetujuan
          </h3>

          <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
            <div class="flex items-start gap-3">
              <i class="fas fa-check-circle text-emerald-500 mt-1"></i>
              <div>
                <p class="text-emerald-700 font-medium mb-1">Catatan:</p>
                <p class="text-emerald-600 whitespace-pre-line">{{ $permohonan->catatan_admin }}</p>
                @if ($permohonan->disetujui_oleh && $permohonan->disetujui_pada)
                  <p class="text-xs text-emerald-500 mt-2">
                    Disetujui oleh: {{ $permohonan->disetujuiOleh->name ?? 'Admin' }}
                    • {{ \Carbon\Carbon::parse($permohonan->disetujui_pada)->format('d M Y, H:i') }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Bukti -->
      @if ($permohonan->bukti)
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
          <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-paperclip text-indigo-600"></i>
            Bukti Pendukung
          </h3>

          <div class="p-4 border border-slate-200 rounded-lg">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                  @if (pathinfo($permohonan->bukti, PATHINFO_EXTENSION) == 'pdf')
                    <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                  @else
                    <i class="fas fa-file-image text-indigo-600 text-xl"></i>
                  @endif
                </div>
                <div>
                  <p class="font-medium text-slate-800">{{ basename($permohonan->bukti) }}</p>
                  <p class="text-sm text-slate-500">
                    {{ \Carbon\Carbon::parse($permohonan->updated_at)->format('d M Y, H:i') }}
                  </p>
                </div>
              </div>

              <a href="{{ Storage::url($permohonan->bukti) }}" target="_blank"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-download"></i>
                Download
              </a>
            </div>
          </div>
        </div>
      @endif

      <!-- Action Buttons -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200">
        <div class="flex items-center gap-2 text-sm text-slate-600">
          <i class="fas fa-history"></i>
          Terakhir diperbarui: {{ \Carbon\Carbon::parse($permohonan->updated_at)->format('d M Y, H:i') }}
        </div>

        <div class="flex items-center gap-3">
          <a href="{{ route('karyawan.permohonan.index') }}"
            class="px-4 py-2.5 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
          </a>

          @if ($permohonan->status == 'pending')
            <a href="{{ route('karyawan.permohonan.edit', $permohonan->id) }}"
              class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
              <i class="fas fa-edit"></i>
              Edit
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
