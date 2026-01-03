<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin')</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- CSRF Token untuk Laravel -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>

  @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen text-slate-800 font-sans">
  <!-- Logout Form Tersembunyi -->
  <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
    @csrf
  </form>

  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside
      class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col border-r border-slate-800 overflow-y-auto no-scrollbar">
      <div class="p-6">
        <h1 class="text-2xl font-bold text-white tracking-wider">
          Admin<span class="text-indigo-400">Panel</span>
        </h1>
      </div>

      <nav class="mt-2 flex-1 space-y-1 px-4 pb-6">
        <!-- Home -->
        <a href="{{ route('admin.dashboard') }}"
          class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
          <i class="fas fa-home w-5 text-white"></i>
          <span class="ml-3 font-medium">Home</span>
        </a>

        <!-- Master Data -->
        <div class="mt-4 pt-4 border-t border-slate-800">
          <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Master Data</p>

          <!-- Pegawai -->
          <a href="{{ route('admin.pegawai.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i class="fas fa-users w-5 text-white"></i>
            <span class="ml-3 font-medium">Pegawai</span>
          </a>

          <!-- Jabatan -->
          <a href="{{ route('admin.jabatan.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.jabatan.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i class="fas fa-briefcase w-5 text-white"></i>
            <span class="ml-3 font-medium">Jabatan</span>
          </a>

          <!-- Lokasi Presensi -->
          <a href="{{ route('admin.lokasi-presensi.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.lokasi-presensi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i class="fas fa-map-marker-alt w-5 text-white"></i>
            <span class="ml-3 font-medium">Lokasi Presensi</span>
          </a>

          <!-- Jadwal Absensi (Baru) -->
          <a href="{{ route('admin.jadwal-absensi.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.jadwal-absensi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i class="fas fa-calendar-alt w-5 text-white"></i>
            <span class="ml-3 font-medium">Jadwal Absensi</span>
          </a>
        </div>

        <!-- Laporan -->
        <div class="mt-4 pt-4 border-t border-slate-800">
          <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Laporan</p>
          <a href="{{ route('admin.rekap-absensi.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.rekap-absensi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i
              class="fas fa-file-alt w-5 {{ request()->routeIs('admin.rekap-absensi.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
            <span class="ml-3 font-medium">Rekap Absensi</span>
          </a>
        </div>

        <!-- Ketidakhadiran -->
        <div class="mt-4 pt-2">
          <a href="{{ route('admin.ketidakhadiran.index') }}"
            class="flex items-center px-4 py-3 {{ request()->routeIs('admin.ketidakhadiran.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group">
            <i class="fas fa-user-times w-5 text-slate-400 group-hover:text-white transition-colors"></i>
            <span class="ml-3 font-medium">Ketidakhadiran</span>
          </a>
        </div>

        <!-- Logout -->
        <div class="mt-8 pt-4 border-t border-slate-800">
          <button onclick="confirmLogout()"
            class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-xl transition-all group">
            <i class="fas fa-sign-out-alt w-5 text-red-400 group-hover:text-red-300 transition-colors"></i>
            <span class="ml-3 font-medium">Logout</span>
          </button>
        </div>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto relative">
      <!-- Header -->
      <header
        class="bg-slate-900 border-b border-slate-800 h-16 flex items-center justify-between px-6 py-6 sticky top-0 z-30 shadow-md">
        <button class="md:hidden text-slate-300 hover:text-white"><i class="fas fa-bars text-xl"></i></button>
        <div class="hidden md:block"></div>

        <div class="flex items-center gap-4">
          <button class="text-slate-400 hover:text-white transition relative">
            <i class="fas fa-bell"></i>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="h-8 w-[1px] bg-slate-700 mx-2"></div>
          <div class="flex items-center gap-3 text-sm font-medium text-slate-300">
            <div class="text-right hidden sm:block">
              <p class="text-white font-bold">{{ auth()->user()->name ?? 'Super Admin' }}</p>
              <p class="text-xs text-slate-400">{{ auth()->user()->jabatan->nama ?? 'IT Department' }}</p>
            </div>
            <div
              class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center border border-indigo-400 text-white shadow-lg shadow-indigo-500/20">
              <i class="fas fa-user-shield"></i>
            </div>
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <main class="p-6 md:p-8 flex-1 bg-gray-50">
        <!-- Page Header -->
        <div
          class="mb-6 bg-indigo-600 rounded-lg p-4 text-white shadow-lg flex flex-col md:flex-row justify-between items-center">
          <div>
            <h2 class="text-lg font-bold">Dashboard Administrator</h2>
            <p class="text-indigo-100 text-sm opacity-90">Sistem Absensi Pegawai Online</p>
          </div>
          <div class="mt-2 md:mt-0 text-sm font-medium bg-indigo-700 px-3 py-1 rounded border border-indigo-500">
            {{ date('l, d F Y') }}
          </div>
        </div>

        <!-- Konten Dashboard -->
        @yield('admin-content')
      </main>
    </div>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-sign-out-alt text-2xl text-red-600"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Logout</h3>
        <p class="text-slate-600">Yakin ingin keluar dari sistem?</p>
      </div>
      <div class="flex gap-3">
        <button onclick="hideLogoutModal()"
          class="flex-1 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
          Batal
        </button>
        <button onclick="submitLogout()"
          class="flex-1 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
          Ya, Logout
        </button>
      </div>
    </div>
  </div>

  @stack('scripts')
  <script>
    // Fungsi logout
    function confirmLogout() {
      document.getElementById('logoutModal').classList.remove('hidden');
    }

    function hideLogoutModal() {
      document.getElementById('logoutModal').classList.add('hidden');
    }

    function submitLogout() {
      document.getElementById('logoutForm').submit();
    }
  </script>
</body>

</html>
