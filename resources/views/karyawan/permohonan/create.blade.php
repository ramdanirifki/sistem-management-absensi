@extends('layouts.karyawan')

@section('title', 'Ajukan Permohonan')
@section('page-title', 'Ajukan Permohonan Baru')
@section('page-description', 'Isi formulir untuk mengajukan permohonan izin, sakit, atau cuti')

@section('content')
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
      <!-- Breadcrumb -->
      <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('karyawan.permohonan.index') }}" class="hover:text-indigo-600">
          Permohonan
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Ajukan Baru</span>
      </div>

      <!-- Form -->
      <form action="{{ route('karyawan.permohonan.store') }}" method="POST" enctype="multipart/form-data"
        id="permohonanForm">
        @csrf

        <div class="space-y-6">
          <!-- Jenis Permohonan -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-3">Jenis Permohonan *</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <label class="relative">
                <input type="radio" name="jenis" value="izin" required class="peer hidden">
                <div
                  class="p-4 border-2 border-slate-200 rounded-lg cursor-pointer transition-all 
                                        hover:border-blue-500 hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                      <i class="fas fa-user-clock text-blue-600"></i>
                    </div>
                    <div>
                      <p class="font-medium text-slate-800">Izin</p>
                      <p class="text-xs text-slate-500">Keperluan pribadi</p>
                    </div>
                  </div>
                </div>
              </label>

              <label class="relative">
                <input type="radio" name="jenis" value="sakit" required class="peer hidden">
                <div
                  class="p-4 border-2 border-slate-200 rounded-lg cursor-pointer transition-all 
                                        hover:border-red-500 hover:bg-red-50 peer-checked:border-red-500 peer-checked:bg-red-50">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                      <i class="fas fa-heartbeat text-red-600"></i>
                    </div>
                    <div>
                      <p class="font-medium text-slate-800">Sakit</p>
                      <p class="text-xs text-slate-500">Tidak masuk karena sakit</p>
                    </div>
                  </div>
                </div>
              </label>

              <label class="relative">
                <input type="radio" name="jenis" value="cuti" required class="peer hidden">
                <div
                  class="p-4 border-2 border-slate-200 rounded-lg cursor-pointer transition-all 
                                        hover:border-purple-500 hover:bg-purple-50 peer-checked:border-purple-500 peer-checked:bg-purple-50">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                      <i class="fas fa-umbrella-beach text-purple-600"></i>
                    </div>
                    <div>
                      <p class="font-medium text-slate-800">Cuti</p>
                      <p class="text-xs text-slate-500">Cuti tahunan/tahunan</p>
                    </div>
                  </div>
                </div>
              </label>
            </div>
            @error('jenis')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tanggal -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai *</label>
              <input type="date" name="tanggal_mulai" required id="tanggal_mulai"
                value="{{ old('tanggal_mulai', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
              @error('tanggal_mulai')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai *</label>
              <input type="date" name="tanggal_selesai" required id="tanggal_selesai"
                value="{{ old('tanggal_selesai', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
              @error('tanggal_selesai')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Alasan -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Alasan *</label>
            <textarea name="alasan" rows="4" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Jelaskan alasan permohonan Anda">{{ old('alasan') }}</textarea>
            @error('alasan')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Bukti -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Bukti Pendukung (Opsional)</label>
            <div
              class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition"
              onclick="document.getElementById('bukti').click()">
              <input type="file" name="bukti" id="bukti" class="hidden" accept=".jpg,.jpeg,.png,.pdf">

              <div id="uploadArea" class="cursor-pointer">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-indigo-100 flex items-center justify-center">
                  <i class="fas fa-cloud-upload-alt text-indigo-600 text-xl"></i>
                </div>
                <p class="text-slate-700 font-medium">Klik untuk upload file</p>
                <p class="text-sm text-slate-500 mt-1">Format: JPG, PNG, PDF (Maks: 2MB)</p>
              </div>

              <div id="previewArea" class="hidden">
                <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
                  <div class="flex items-center gap-3">
                    <i class="fas fa-file text-indigo-600"></i>
                    <div>
                      <p id="fileName" class="text-sm font-medium text-slate-800"></p>
                      <p id="fileSize" class="text-xs text-slate-500"></p>
                    </div>
                  </div>
                  <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </div>
            @error('bukti')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center justify-between pt-6 border-t border-slate-200">
            <a href="{{ route('karyawan.permohonan.index') }}"
              class="px-4 py-2.5 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
              Batal
            </a>

            <button type="submit"
              class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
              <i class="fas fa-paper-plane"></i>
              Ajukan Permohonan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        const durasiInput = document.getElementById('durasi');
        const buktiInput = document.getElementById('bukti');
        const uploadArea = document.getElementById('uploadArea');
        const previewArea = document.getElementById('previewArea');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        // Calculate duration
        function calculateDuration() {
          if (tanggalMulai.value && tanggalSelesai.value) {
            const start = new Date(tanggalMulai.value);
            const end = new Date(tanggalSelesai.value);

            if (end < start) {
              tanggalSelesai.value = tanggalMulai.value;
              return calculateDuration();
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (diffDays > 0) {
              durasiInput.value = diffDays;
            }
          }
        }

        tanggalMulai.addEventListener('change', calculateDuration);
        tanggalSelesai.addEventListener('change', calculateDuration);

        // File upload preview
        buktiInput.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);

            fileName.textContent = file.name;
            fileSize.textContent = `${sizeInMB} MB`;

            uploadArea.classList.add('hidden');
            previewArea.classList.remove('hidden');
          }
        });

        function removeFile() {
          buktiInput.value = '';
          uploadArea.classList.remove('hidden');
          previewArea.classList.add('hidden');
        }

        // Form validation
        document.getElementById('permohonanForm').addEventListener('submit', function(e) {
          const jenis = document.querySelector('input[name="jenis"]:checked');

          if (!jenis) {
            e.preventDefault();
            alert('Silakan pilih jenis permohonan');
            return false;
          }

          return true;
        });
      });
    </script>
  @endpush
@endsection
