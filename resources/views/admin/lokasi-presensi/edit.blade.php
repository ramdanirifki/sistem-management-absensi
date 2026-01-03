@extends('layouts.admin')

@section('title', 'Edit Lokasi Presensi')
@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Edit Lokasi Presensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.lokasi-presensi.index') }}" class="text-slate-400 hover:text-indigo-600">Lokasi
          Presensi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Edit Lokasi</span>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.lokasi-presensi.index') }}"
        class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-slate-800">Edit Lokasi Presensi</h2>
      <p class="text-slate-600">Perbarui data lokasi presensi</p>
    </div>

    <form action="{{ route('admin.lokasi-presensi.update', $lokasi->id) }}" method="POST" id="lokasiForm">
      @csrf
      @method('PUT')
      <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lokasi *</label>
            <input type="text" name="nama" value="{{ old('name', $lokasi->nama) }}" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: Kantor Pusat, Kantor Cabang, Gedung A">
            @error('nama')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Radius (meter) *</label>
            <input type="number" name="radius_meter" value="{{ old('radius_meter', $lokasi->radius_meter) }}" required
              min="10"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: 100">
            <p class="mt-1 text-xs text-slate-500">Jarak maksimal dari titik koordinat untuk bisa absen</p>
            @error('radius_meter')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap *</label>
          <textarea name="alamat" rows="2" required
            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            placeholder="Alamat lengkap lokasi presensi">{{ old('alamat', $lokasi->alamat) }}</textarea>
          @error('alamat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Latitude *</label>
            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $lokasi->latitude) }}" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: -6.2088">
            <p class="mt-1 text-xs text-slate-500">Gunakan titik (.) sebagai pemisah desimal</p>
            @error('latitude')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Longitude *</label>
            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $lokasi->longitude) }}"
              required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: 106.8456">
            @error('longitude')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
          <div class="flex items-center gap-2 mb-3">
            <i class="fas fa-map-marked-alt text-blue-500"></i>
            <span class="font-medium text-blue-700">Ambil Koordinat Otomatis</span>
          </div>
          <button type="button" id="getLocationBtn"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
            <i class="fas fa-location-arrow mr-2"></i>Ambil Lokasi Saat Ini
          </button>
          <p class="mt-2 text-xs text-blue-600">Klik tombol di atas untuk mengambil koordinat lokasi perangkat Anda saat
            ini.</p>
        </div>

        <div>
          <label class="flex items-center">
            <input type="checkbox" name="aktif" value="1" {{ old('aktif', $lokasi->aktif) ? 'checked' : '' }}
              class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <span class="ml-2 text-sm text-slate-700">Aktifkan lokasi ini untuk presensi</span>
          </label>
          @error('aktif')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex gap-3 mt-8">
        <a href="{{ route('admin.lokasi-presensi.index') }}"
          class="flex-1 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition text-center">
          Batal
        </a>
        <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          Update Lokasi
        </button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const getLocationBtn = document.getElementById('getLocationBtn');
      const latitudeInput = document.getElementById('latitude');
      const longitudeInput = document.getElementById('longitude');

      if (getLocationBtn) {
        getLocationBtn.addEventListener('click', function() {
          if (navigator.geolocation) {
            getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengambil lokasi...';
            getLocationBtn.disabled = true;

            navigator.geolocation.getCurrentPosition(
              function(position) {
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);

                latitudeInput.value = lat;
                longitudeInput.value = lng;

                getLocationBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Lokasi Diambil';
                getLocationBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                getLocationBtn.classList.add('bg-green-600', 'hover:bg-green-700');

                setTimeout(() => {
                  getLocationBtn.innerHTML =
                    '<i class="fas fa-location-arrow mr-2"></i>Ambil Lokasi Saat Ini';
                  getLocationBtn.disabled = false;
                  getLocationBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                  getLocationBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 2000);
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

                alert(errorMessage);
                getLocationBtn.innerHTML = '<i class="fas fa-location-arrow mr-2"></i>Ambil Lokasi Saat Ini';
                getLocationBtn.disabled = false;
              }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
              }
            );
          } else {
            alert('Browser tidak mendukung geolocation.');
          }
        });
      }
    });
  </script>
@endsection
