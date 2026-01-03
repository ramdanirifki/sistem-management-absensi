@extends('layouts.karyawan')

@section('title', 'Absensi')
@section('page-title', 'Absensi')
@section('page-description', 'Lakukan absensi masuk atau pulang')

@section('content')
  <div class="space-y-6">
    <!-- Status Absensi Hari Ini -->
    <div class="bg-white rounded-xl shadow p-6">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Status Absensi Hari Ini</h3>
          <p class="text-slate-600 text-sm">{{ date('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="text-center">
            <div class="text-2xl font-bold text-indigo-600" id="currentTime">{{ date('H:i:s') }}</div>
            <div class="text-xs text-slate-500">Waktu Server</div>
          </div>
          <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
            <i class="fas fa-clock text-indigo-600 text-xl"></i>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Card Jam Masuk -->
        <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
          <div class="flex items-center justify-between mb-4">
            <div>
              <p class="text-sm text-slate-600">Jam Masuk</p>
              <p class="text-2xl font-bold text-slate-800">
                @if ($absensiHariIni && $absensiHariIni->jam_masuk)
                  {{ date('H:i', strtotime($absensiHariIni->jam_masuk)) }}
                @else
                  --:--
                @endif
              </p>
            </div>
            <div
              class="w-12 h-12 rounded-lg {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'bg-emerald-100' : 'bg-slate-200' }} flex items-center justify-center">
              <i
                class="fas fa-sign-in-alt text-lg {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'text-emerald-600' : 'text-slate-400' }}"></i>
            </div>
          </div>
          <div class="space-y-2">
            @if ($absensiHariIni && $absensiHariIni->jam_masuk)
              <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">Status:</span>
                <span
                  class="font-medium {{ $absensiHariIni->status_masuk == 'hadir' ? 'text-emerald-600' : 'text-yellow-600' }}">
                  {{ $absensiHariIni->status_masuk == 'hadir' ? 'Tepat Waktu' : 'Terlambat' }}
                </span>
              </div>
            @else
              <p class="text-sm text-slate-500 italic">Belum melakukan absensi masuk</p>
            @endif
          </div>
        </div>

        <!-- Card Jam Pulang -->
        <div class="bg-slate-50 rounded-lg p-5 border border-slate-200">
          <div class="flex items-center justify-between mb-4">
            <div>
              <p class="text-sm text-slate-600">Jam Pulang</p>
              <p class="text-2xl font-bold text-slate-800">
                @if ($absensiHariIni && $absensiHariIni->jam_pulang)
                  {{ date('H:i', strtotime($absensiHariIni->jam_pulang)) }}
                @else
                  --:--
                @endif
              </p>
            </div>
            <div
              class="w-12 h-12 rounded-lg {{ $absensiHariIni && $absensiHariIni->jam_pulang ? 'bg-emerald-100' : 'bg-slate-200' }} flex items-center justify-center">
              <i
                class="fas fa-sign-out-alt text-lg {{ $absensiHariIni && $absensiHariIni->jam_pulang ? 'text-emerald-600' : 'text-slate-400' }}"></i>
            </div>
          </div>
          <div class="space-y-2">
            @if ($absensiHariIni && $absensiHariIni->jam_pulang)
              <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">Status:</span>
                <span
                  class="font-medium {{ $absensiHariIni->status_pulang == 'normal' ? 'text-emerald-600' : 'text-orange-600' }}">
                  {{ $absensiHariIni->status_pulang == 'normal' ? 'Normal' : 'Cepat Pulang' }}
                </span>
              </div>
            @else
              <p class="text-sm text-slate-500 italic">
                {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'Belum absen pulang' : 'Belum absen masuk' }}
              </p>
            @endif
          </div>
        </div>
      </div>

      <!-- Jadwal Kerja -->
      @if ($jadwal)
        @php
          // Hitung waktu mulai absen (1 jam sebelum jam masuk)
          $jamMasuk = \Carbon\Carbon::parse($jadwal->jam_masuk);
          $jamMulaiAbsen = $jamMasuk->copy()->subHour();
        @endphp

        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
          <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-calendar-alt text-blue-500"></i>
            <h4 class="font-medium text-blue-800">Jadwal Kerja Anda</h4>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-sign-in-alt text-green-600"></i>
              </div>
              <div>
                <p class="font-medium text-slate-700">Masuk</p>
                <p class="text-slate-600">{{ date('H:i', strtotime($jadwal->jam_masuk)) }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-sign-out-alt text-red-600"></i>
              </div>
              <div>
                <p class="font-medium text-slate-700">Pulang</p>
                <p class="text-slate-600">{{ date('H:i', strtotime($jadwal->jam_pulang)) }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
              </div>
              <div>
                <p class="font-medium text-slate-700">Toleransi</p>
                <p class="text-slate-600">{{ $jadwal->toleransi_keterlambatan }} menit</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                <i class="fas fa-hourglass-start text-indigo-600"></i>
              </div>
              <div>
                <p class="font-medium text-slate-700">Mulai Absen</p>
                <p class="text-slate-600">{{ $jamMulaiAbsen->format('H:i') }}</p>
              </div>
            </div>
          </div>

          <!-- Info waktu saat ini -->
          @php
            $sekarang = \Carbon\Carbon::now();
            $bisaAbsen = $sekarang->gte($jamMulaiAbsen);
          @endphp

          <div class="mt-3 pt-3 border-t border-blue-200">
            <p class="text-sm {{ $bisaAbsen ? 'text-green-700' : 'text-yellow-700' }}">
              <i class="fas fa-info-circle mr-1"></i>
              @if ($bisaAbsen)
                <span class="font-medium">Bisa absen masuk sekarang</span>
                (dari {{ $jamMulaiAbsen->format('H:i') }} -
                {{ \Carbon\Carbon::parse($jadwal->jam_pulang)->format('H:i') }})
              @else
                <span class="font-medium">Belum waktunya absen</span>
                (bisa mulai {{ $jamMulaiAbsen->format('H:i') }})
              @endif
            </p>
          </div>
        </div>
      @endif

      <!-- Lokasi Presensi -->
      @if ($lokasiAktif)
        <div class="mb-6 p-4 bg-emerald-50 rounded-lg border border-emerald-200">
          <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-map-marker-alt text-emerald-500"></i>
            <h4 class="font-medium text-emerald-800">Lokasi Presensi Aktif</h4>
          </div>
          <div class="space-y-2 text-sm">
            <p class="font-medium text-slate-700">{{ $lokasiAktif->nama }}</p>
            <p class="text-slate-600">{{ $lokasiAktif->alamat }}</p>
            <p class="text-slate-500">
              <i class="fas fa-expand-arrows-alt mr-1"></i>
              Radius: {{ $lokasiAktif->radius_meter }} meter
            </p>
          </div>
        </div>
      @else
        <div class="mb-6 p-4 bg-red-50 rounded-lg border border-red-200">
          <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-red-500"></i>
            <p class="text-red-700">Tidak ada lokasi presensi yang aktif. Hubungi admin.</p>
          </div>
        </div>
      @endif
    </div>

    <!-- Form Absensi -->
    @if ($lokasiAktif)
      <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Form Absensi</h3>

        <div class="mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
          <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-location-arrow text-indigo-500"></i>
            <h4 class="font-medium text-indigo-800">Lokasi Anda Saat Ini</h4>
          </div>
          <div class="space-y-2">
            <div id="locationStatus" class="text-sm">
              <i class="fas fa-spinner fa-spin mr-2"></i>
              <span>Mengambil lokasi...</span>
            </div>
            <div id="locationInfo" class="hidden">
              <p class="text-sm text-slate-600">
                Latitude: <span id="currentLatitude" class="font-mono"></span>
              </p>
              <p class="text-sm text-slate-600">
                Longitude: <span id="currentLongitude" class="font-mono"></span>
              </p>
              <p class="text-sm text-slate-600">
                Jarak dari lokasi: <span id="distanceInfo" class="font-medium"></span>
              </p>
            </div>
            <button id="refreshLocation" class="text-xs text-indigo-600 hover:text-indigo-800">
              <i class="fas fa-sync-alt mr-1"></i>Refresh Lokasi
            </button>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Form Masuk -->
          <form action="{{ route('karyawan.absensi.masuk') }}" method="POST" id="masukForm"
            class="border border-slate-200 rounded-lg p-5 {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'opacity-50' : '' }}"
            {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'onsubmit="return false;"' : '' }}>
            @csrf
            <input type="hidden" name="latitude" id="masukLatitude">
            <input type="hidden" name="longitude" id="masukLongitude">

            <div class="mb-4">
              <h4 class="font-bold text-slate-800 text-lg mb-2">Absensi Masuk</h4>
              <p class="text-sm text-slate-600">Lakukan absensi masuk sesuai jam kerja</p>
            </div>

            <div class="mb-6">
              <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
              <textarea name="catatan" rows="3"
                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                placeholder="Contoh: Meeting pagi, lembur kemarin, work from home, dll.">{{ $absensiHariIni && $absensiHariIni->catatan_masuk ? $absensiHariIni->catatan_masuk : '' }}</textarea>
              <p class="text-xs text-slate-500 mt-1">Maksimal 255 karakter</p>
            </div>

            <button type="submit"
              class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
              id="masukButton" {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'disabled' : '' }}>
              <i class="fas fa-fingerprint"></i>
              {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'Sudah Absen Masuk' : 'Absen Masuk Sekarang' }}
            </button>
          </form>

          <!-- Form Pulang -->
          <form action="{{ route('karyawan.absensi.pulang') }}" method="POST" id="pulangForm"
            class="border border-slate-200 rounded-lg p-5 {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang ? 'opacity-50' : '' }}"
            {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang ? 'onsubmit="return false;"' : '' }}>
            @csrf
            <input type="hidden" name="latitude" id="pulangLatitude">
            <input type="hidden" name="longitude" id="pulangLongitude">

            <div class="mb-4">
              <h4 class="font-bold text-slate-800 text-lg mb-2">Absensi Pulang</h4>
              <p class="text-sm text-slate-600">Lakukan absensi pulang setelah bekerja</p>
            </div>

            <div class="mb-6">
              <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
              <textarea name="catatan" rows="3"
                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                placeholder="Contoh: Laporan selesai, meeting client, tugas hari ini, dll.">{{ $absensiHariIni && $absensiHariIni->catatan_pulang ? $absensiHariIni->catatan_pulang : '' }}</textarea>
              <p class="text-xs text-slate-500 mt-1">Maksimal 255 karakter</p>
            </div>

            <button type="submit"
              class="w-full py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
              id="pulangButton"
              {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang ? 'disabled' : '' }}>
              <i class="fas fa-sign-out-alt"></i>
              @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                Belum Absen Masuk
              @elseif($absensiHariIni->jam_pulang)
                Sudah Absen Pulang
              @else
                Absen Pulang Sekarang
              @endif
            </button>
          </form>
        </div>

        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200 text-sm text-yellow-800">
          <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-circle mt-0.5"></i>
            <div>
              <p class="font-medium mb-1">Perhatian:</p>
              <ul class="list-disc list-inside space-y-1">
                <li>Pastikan GPS/Lokasi aktif di perangkat Anda</li>
                <li>Anda harus berada dalam radius {{ $lokasiAktif->radius_meter }} meter dari lokasi presensi</li>
                <li>Absen masuk hanya bisa dilakukan mulai
                  {{ $jamMulaiAbsen->format('H:i') ?? '1 jam sebelum jam masuk' }}</li>
                <li>Absensi diluar jam kerja akan dicatat sebagai keterlambatan/cepat pulang</li>
                <li>Tidak bisa absen masuk setelah jam
                  {{ \Carbon\Carbon::parse($jadwal->jam_pulang)->format('H:i') ?? 'pulang' }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  <script>
    function checkAbsenTime() {
      const now = new Date();
      const currentHour = now.getHours();
      const currentMinute = now.getMinutes();

      // Contoh: jam masuk 08:00, mulai absen 07:00 (1 jam sebelumnya)
      const jamMulaiAbsenHour = 7; // 07:00
      const jamMulaiAbsenMinute = 0;

      // Hitung total menit
      const currentTotalMinutes = currentHour * 60 + currentMinute;
      const mulaiAbsenTotalMinutes = jamMulaiAbsenHour * 60 + jamMulaiAbsenMinute;

      const masukButton = document.getElementById('masukButton');
      if (masukButton && !masukButton.disabled) {
        if (currentTotalMinutes < mulaiAbsenTotalMinutes) {
          masukButton.disabled = true;
          masukButton.innerHTML = '<i class="fas fa-clock"></i> Belum Waktunya Absen';

          // Hitung menit tunggu
          const menitTunggu = mulaiAbsenTotalMinutes - currentTotalMinutes;
          const jamTunggu = Math.floor(menitTunggu / 60);
          const menitSisa = menitTunggu % 60;

          // Tambahkan tooltip/info
          masukButton.title = `Absen bisa dilakukan mulai 07:00 (${jamTunggu} jam ${menitSisa} menit lagi)`;
        }
      }
    }

    // Panggil di DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
      checkAbsenTime();
      // Cek setiap menit
      setInterval(checkAbsenTime, 60000);
    });

    // Update waktu real-time
    function updateTime() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      document.getElementById('currentTime').textContent = timeString;
    }

    setInterval(updateTime, 1000);

    // Get current location
    function getLocation() {
      const locationStatus = document.getElementById('locationStatus');
      const locationInfo = document.getElementById('locationInfo');
      const currentLatitude = document.getElementById('currentLatitude');
      const currentLongitude = document.getElementById('currentLongitude');
      const distanceInfo = document.getElementById('distanceInfo');

      locationStatus.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Mengambil lokasi...</span>';

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            const lat = position.coords.latitude.toFixed(6);
            const lng = position.coords.longitude.toFixed(6);

            // Update location info
            currentLatitude.textContent = lat;
            currentLongitude.textContent = lng;

            // Set form values
            document.getElementById('masukLatitude').value = lat;
            document.getElementById('masukLongitude').value = lng;
            document.getElementById('pulangLatitude').value = lat;
            document.getElementById('pulangLongitude').value = lng;

            // Calculate distance from presensi location
            const lokasiLat = {{ $lokasiAktif->latitude ?? 0 }};
            const lokasiLng = {{ $lokasiAktif->longitude ?? 0 }};
            const radius = {{ $lokasiAktif->radius_meter ?? 100 }};

            if (lokasiLat && lokasiLng) {
              const distance = calculateDistance(lat, lng, lokasiLat, lokasiLng);
              distanceInfo.textContent = distance.toFixed(1) + ' meter';

              if (distance <= radius) {
                distanceInfo.className = 'font-medium text-emerald-600';
                distanceInfo.innerHTML = distance.toFixed(1) + ' meter <i class="fas fa-check-circle ml-1"></i>';
              } else {
                distanceInfo.className = 'font-medium text-red-600';
                distanceInfo.innerHTML = distance.toFixed(1) + ' meter <i class="fas fa-times-circle ml-1"></i>';
              }
            }

            locationStatus.innerHTML =
              '<i class="fas fa-check-circle text-emerald-600 mr-2"></i><span>Lokasi berhasil diambil</span>';
            locationInfo.classList.remove('hidden');
          },
          function(error) {
            let errorMessage = 'Gagal mengambil lokasi. ';
            switch (error.code) {
              case error.PERMISSION_DENIED:
                errorMessage += 'Izin lokasi ditolak.';
                break;
              case error.POSITION_UNAVAILABLE:
                errorMessage += 'Informasi lokasi tidak tersedia.';
                break;
              case error.TIMEOUT:
                errorMessage += 'Permintaan lokasi timeout.';
                break;
              default:
                errorMessage += 'Error tidak diketahui.';
            }

            locationStatus.innerHTML =
              `<i class="fas fa-exclamation-triangle text-red-600 mr-2"></i><span>${errorMessage}</span>`;

            // Disable buttons if location failed
            document.getElementById('masukButton').disabled = true;
            document.getElementById('pulangButton').disabled = true;
          }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
          }
        );
      } else {
        locationStatus.innerHTML =
          '<i class="fas fa-exclamation-triangle text-red-600 mr-2"></i><span>Browser tidak mendukung geolocation</span>';
      }
    }

    // Calculate distance between two coordinates
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371000; // Radius bumi dalam meter
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    }

    // Preview image
    function previewImage(input, previewId) {
      const preview = document.getElementById(previewId);
      const file = input.files[0];

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          preview.querySelector('img').src = e.target.result;
          preview.classList.remove('hidden');
        }

        reader.readAsDataURL(file);

        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
          alert('Ukuran file terlalu besar! Maksimal 2MB.');
          input.value = '';
          preview.classList.add('hidden');
        }
      }
    }

    // Form submission with confirmation
    document.getElementById('masukForm')?.addEventListener('submit', function(e) {
      if (!confirm('Apakah Anda yakin melakukan absensi masuk?')) {
        e.preventDefault();
      }
    });

    document.getElementById('pulangForm')?.addEventListener('submit', function(e) {
      if (!confirm('Apakah Anda yakin melakukan absensi pulang?')) {
        e.preventDefault();
      }
    });

    // Refresh location button
    document.getElementById('refreshLocation')?.addEventListener('click', getLocation);

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
      getLocation();

      // Auto-refresh every 30 seconds
      setInterval(() => {
        getLocation();
      }, 30000);
    });
  </script>
@endsection
