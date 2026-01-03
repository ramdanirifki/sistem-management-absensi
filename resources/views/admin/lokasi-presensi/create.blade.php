@extends('layouts.admin')

@section('title', 'Tambah Lokasi Presensi')
@section('admin-content')
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Tambah Lokasi Presensi</h2>
      <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
        <span>Admin</span> <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.lokasi-presensi.index') }}" class="text-slate-400 hover:text-indigo-600">Kelola Lokasi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-indigo-600 font-medium">Tambah Baru</span>
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
    <div class="pb-6 border-b mt-6 mx-6">
      <h2 class="text-2xl font-bold text-slate-800">Tambah Lokasi Presensi Baru</h2>
      <p class="text-slate-600 text-sm mt-1">Isi form berikut untuk menambahkan lokasi presensi baru</p>
    </div>

    <form action="{{ route('admin.lokasi-presensi.store') }}" class="p-6" method="POST" id="lokasiForm">
      @csrf
      <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lokasi *</label>
            <input type="text" name="nama" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: Kantor Pusat, Kantor Cabang, Gedung A">
            @error('nama')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Radius (meter) *</label>
            <input type="number" name="radius_meter" required min="10"
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: 10">
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
            placeholder="Alamat lengkap lokasi presensi"></textarea>
          @error('alamat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Latitude *</label>
            <input type="text" name="latitude" id="latitude" required
              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="Contoh: -6.2088">
            <p class="mt-1 text-xs text-slate-500">Gunakan titik (.) sebagai pemisah desimal</p>
            @error('latitude')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Longitude *</label>
            <input type="text" name="longitude" id="longitude" required
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
            <input type="checkbox" name="aktif" value="1" checked
              class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <span class="ml-2 text-sm text-slate-700">Aktifkan lokasi ini untuk presensi</span>
          </label>
          @error('aktif')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.lokasi-presensi.index') }}"
          class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
          Batal
        </a>
        <button type="submit"
          class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
          <i class="fas fa-save"></i> Simpan Lokasi
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
