@extends('layouts.admin')

@section('title', 'Edit Ketidakhadiran - Admin Absensi')

@section('page-title', 'Edit Ketidakhadiran')
@section('page-description', 'Form edit pengajuan ketidakhadiran')

@section('admin-content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-lg font-bold text-slate-800 mb-6">Edit Pengajuan Ketidakhadiran</h3>

      <form method="POST" action="{{ route('admin.ketidakhadiran.update', $ketidakhadiran->id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">
          <!-- Info User (readonly) -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">User</label>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                  <i class="fas fa-user text-indigo-600"></i>
                </div>
                <div>
                  <p class="font-medium text-slate-800">{{ $ketidakhadiran->user->name }}</p>
                  <p class="text-sm text-slate-500">{{ $ketidakhadiran->user->email }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Info Jenis (readonly) -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Ketidakhadiran</label>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
              @php
                $jenisIcons = [
                    'cuti' => ['icon' => 'fa-umbrella-beach', 'color' => 'text-blue-600 bg-blue-100'],
                    'izin' => ['icon' => 'fa-file-signature', 'color' => 'text-purple-600 bg-purple-100'],
                    'sakit' => ['icon' => 'fa-heartbeat', 'color' => 'text-red-600 bg-red-100'],
                ];
              @endphp
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-full {{ $jenisIcons[$ketidakhadiran->jenis]['color'] ?? 'bg-slate-100 text-slate-600' }} flex items-center justify-center">
                  <i class="fas {{ $jenisIcons[$ketidakhadiran->jenis]['icon'] ?? 'fa-question' }}"></i>
                </div>
                <div>
                  <p class="font-medium text-slate-800">{{ ucfirst($ketidakhadiran->jenis) }}</p>
                  <p class="text-sm text-slate-500">
                    {{ $ketidakhadiran->jenis == 'cuti'
                        ? 'Keperluan pribadi'
                        : ($ketidakhadiran->jenis == 'izin'
                            ? 'Keperluan mendadak'
                            : 'Kondisi kesehatan') }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Info Tanggal (readonly) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai - Selesai</label>
              <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-emerald-600"></i>
                  </div>
                  <div>
                    <p class="font-medium text-slate-800">
                      {{ $ketidakhadiran->tanggal_mulai->format('d/m/Y') }} -
                      {{ $ketidakhadiran->tanggal_selesai->format('d/m/Y') }}
                    </p>
                    <p class="text-sm text-slate-500">{{ $ketidakhadiran->durasi_hari }} hari</p>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Diajukan Pada</label>
              <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600"></i>
                  </div>
                  <div>
                    <p class="font-medium text-slate-800">{{ $ketidakhadiran->created_at->format('d/m/Y') }}</p>
                    <p class="text-sm text-slate-500">{{ $ketidakhadiran->created_at->format('H:i') }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Info Alasan (readonly) -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Pengajuan</label>
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-comment-dots text-sky-600"></i>
                </div>
                <div class="flex-1">
                  <p class="text-slate-700 whitespace-pre-line">{{ $ketidakhadiran->alasan }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Info Bukti (readonly) -->
          @if ($ketidakhadiran->bukti)
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Bukti yang Dikirim</label>
              <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-violet-100 flex items-center justify-center">
                      <i class="fas fa-paperclip text-violet-600"></i>
                    </div>
                    <div>
                      <p class="font-medium text-slate-800">{{ $ketidakhadiran->bukti }}</p>
                      <p class="text-sm text-slate-500">File bukti pendukung</p>
                    </div>
                  </div>
                  <a href="{{ Storage::url('bukti_ketidakhadiran/' . $ketidakhadiran->bukti) }}" target="_blank"
                    class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                    <i class="fas fa-eye mr-1"></i> Lihat
                  </a>
                </div>
              </div>
            </div>
          @endif

          <!-- Status (edit) -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Status Pengajuan *</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <label
                class="flex items-center p-4 border border-yellow-200 rounded-lg cursor-pointer hover:bg-yellow-50/50">
                <input type="radio" name="status" value="pending" required
                  {{ old('status', $ketidakhadiran->status) == 'pending' ? 'checked' : '' }}
                  class="mr-3 text-yellow-600">
                <div class="flex-1">
                  <div class="font-medium text-slate-800">Pending</div>
                  <div class="text-sm text-slate-500">Menunggu persetujuan</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                  <i class="fas fa-clock text-yellow-600 text-sm"></i>
                </div>
              </label>

              <label class="flex items-center p-4 border border-green-200 rounded-lg cursor-pointer hover:bg-green-50/50">
                <input type="radio" name="status" value="disetujui" required
                  {{ old('status', $ketidakhadiran->status) == 'disetujui' ? 'checked' : '' }}
                  class="mr-3 text-green-600">
                <div class="flex-1">
                  <div class="font-medium text-slate-800">Disetujui</div>
                  <div class="text-sm text-slate-500">Pengajuan diterima</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
              </label>

              <label class="flex items-center p-4 border border-red-200 rounded-lg cursor-pointer hover:bg-red-50/50">
                <input type="radio" name="status" value="ditolak" required
                  {{ old('status', $ketidakhadiran->status) == 'ditolak' ? 'checked' : '' }} class="mr-3 text-red-600">
                <div class="flex-1">
                  <div class="font-medium text-slate-800">Ditolak</div>
                  <div class="text-sm text-slate-500">Pengajuan ditolak</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                  <i class="fas fa-times text-red-600 text-sm"></i>
                </div>
              </label>
            </div>
            @error('status')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Catatan Admin (edit) -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Admin</label>
            <textarea name="catatan_admin" rows="3"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Berikan catatan atau alasan persetujuan/penolakan...">{{ old('catatan_admin', $ketidakhadiran->catatan_admin) }}</textarea>
            <div class="mt-2 flex items-start gap-2 text-sm text-slate-500">
              <i class="fas fa-info-circle text-slate-400 mt-0.5"></i>
              <span>Catatan ini akan dikirim ke user sebagai feedback</span>
            </div>
            @error('catatan_admin')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Info Persetujuan Sebelumnya -->
          @if ($ketidakhadiran->disetujui_oleh && $ketidakhadiran->disetujui_pada)
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Persetujuan Sebelumnya</label>
              <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-user-check text-emerald-600"></i>
                  </div>
                  <div>
                    <p class="font-medium text-slate-800">
                      Disetujui oleh: {{ $ketidakhadiran->disetujuiOleh->name ?? 'Admin' }}
                    </p>
                    <p class="text-sm text-slate-500">
                      Pada: {{ $ketidakhadiran->disetujui_pada->format('d/m/Y H:i') }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <!-- Tombol -->
          <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.ketidakhadiran.index') }}"
              class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">
              <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
              class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
              <i class="fas fa-save"></i> Update Status
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-set disetujui_oleh jika status berubah ke disetujui
      const statusRadios = document.querySelectorAll('input[name="status"]');
      statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
          if (this.value === 'disetujui') {
            // Tampilkan konfirmasi jika sebelumnya bukan disetujui
            const currentStatus = "{{ $ketidakhadiran->status }}";
            if (currentStatus !== 'disetujui') {
              if (!confirm('Anda akan menyetujui pengajuan ini. Lanjutkan?')) {
                // Cari radio yang sebelumnya aktif
                document.querySelector(`input[name="status"][value="${currentStatus}"]`).checked = true;
              }
            }
          }

          if (this.value === 'ditolak') {
            const catatanTextarea = document.querySelector('textarea[name="catatan_admin"]');
            if (catatanTextarea.value.trim() === '') {
              catatanTextarea.focus();
              alert('Harap isi catatan admin untuk alasan penolakan.');
            }
          }
        });
      });
    });
  </script>
@endsection
