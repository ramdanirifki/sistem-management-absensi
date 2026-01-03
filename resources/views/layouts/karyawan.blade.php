<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard Karyawan') - Sistem Absensi</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

<body class="bg-gray-50 min-h-screen text-slate-800">
  <!-- Logout Form -->
  <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
    @csrf
  </form>

  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 hidden lg:flex flex-col shadow-lg">
      <div class="p-6 border-b border-slate-200">
        <h1 class="text-xl font-bold text-slate-800">
          <i class="fas fa-fingerprint text-indigo-600 mr-2"></i>
          Absensi<span class="text-indigo-600">Online</span>
        </h1>
        <p class="text-xs text-slate-500 mt-1">Portal Karyawan</p>
      </div>

      <div class="flex-1 px-4 py-6">
        <!-- User Profile -->
        <div class="bg-indigo-50 rounded-xl p-4 mb-6">
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-indigo-100 border-2 border-white shadow-sm overflow-hidden">
              @if (auth()->user()->foto)
                <img src="{{ Storage::url(auth()->user()->foto) }}" alt="{{ auth()->user()->name }}"
                  class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center">
                  <i class="fas fa-user text-indigo-600 text-lg"></i>
                </div>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="font-semibold text-slate-800 text-sm truncate">{{ auth()->user()->name }}</h3>
              <p class="text-xs text-slate-600 truncate">{{ auth()->user()->jabatan->nama ?? 'Karyawan' }}</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">
          <a href="{{ route('karyawan.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('karyawan.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i
              class="fas fa-home w-5 {{ request()->routeIs('karyawan.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }}"></i>
            <span class="ml-3 font-medium">Dashboard</span>
          </a>

          <a href="{{ route('karyawan.absensi.index') }}"
            class="flex items-center px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('karyawan.absensi.index') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i
              class="fas fa-calendar-check w-5 {{ request()->routeIs('karyawan.absensi.index') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }}"></i>
            <span class="ml-3 font-medium">Absensi</span>
          </a>

          <a href="{{ route('karyawan.absensi.riwayat') }}"
            class="flex items-center px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('karyawan.absensi.riwayat') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i
              class="fas fa-history w-5 {{ request()->routeIs('karyawan.absensi.riwayat') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }}"></i>
            <span class="ml-3 font-medium">Riwayat</span>
          </a>

          <a href="{{ route('karyawan.permohonan.index') }}"
            class="flex items-center px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('karyawan.permohonan.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i
              class="fas fa-file-alt w-5 {{ request()->routeIs('karyawan.permohonan.*') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }}"></i>
            <span class="ml-3 font-medium">Permohonan</span>
          </a>

          <a href="{{ route('karyawan.profil.index') }}"
            class="flex items-center px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('karyawan.profil.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i
              class="fas fa-user-cog w-5 {{ request()->routeIs('karyawan.profil.*') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }}"></i>
            <span class="ml-3 font-medium">Profil</span>
          </a>
        </nav>

        <!-- Logout Button -->
        <div class="mt-8 pt-6 border-t border-slate-200">
          <button onclick="confirmLogout()"
            class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all group">
            <i class="fas fa-sign-out-alt w-5 text-red-600 group-hover:text-red-700"></i>
            <span class="ml-3 font-medium">Logout</span>
          </button>
        </div>
      </div>

      <!-- Footer Sidebar -->
      <div class="p-4 border-t border-slate-200">
        <p class="text-xs text-center text-slate-500">
          &copy; {{ date('Y') }} Sistem Absensi<br>
          <span class="text-[10px]">v1.0.0</span>
        </p>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Mobile Header -->
      <header class="bg-white border-b border-slate-200 lg:hidden">
        <div class="px-4 py-3 flex items-center justify-between">
          <button onclick="toggleSidebar()" class="text-slate-700">
            <i class="fas fa-bars text-lg"></i>
          </button>
          <h1 class="font-semibold text-slate-800">
            <i class="fas fa-fingerprint text-indigo-600 mr-1"></i>
            AbsensiOnline
          </h1>
          <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fas fa-user text-slate-600"></i>
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <main class="flex-1 overflow-y-auto bg-gray-50 p-4 lg:p-6">
        <!-- Page Header -->
        @hasSection('page-title')
          <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">@yield('page-title')</h1>
            @hasSection('page-description')
              <p class="text-slate-600 mt-1">@yield('page-description')</p>
            @endif
          </div>
        @endif

        <!-- Flash Messages -->
        @if (session('success'))
          <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
              <i class="fas fa-check-circle text-emerald-600"></i>
              <span class="text-emerald-700">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
              <i class="fas fa-times"></i>
            </button>
          </div>
        @endif

        @if (session('error'))
          <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
              <i class="fas fa-exclamation-circle text-red-600"></i>
              <span class="text-red-700">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
              <i class="fas fa-times"></i>
            </button>
          </div>
        @endif

        <!-- Content -->
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Mobile Sidebar -->
  <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
    <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl transform transition-transform -translate-x-full">
      <!-- Sidebar content same as desktop -->
    </div>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4">
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
    // Mobile sidebar toggle
    function toggleSidebar() {
      const sidebar = document.getElementById('mobileSidebar');
      sidebar.classList.toggle('hidden');
    }

    // Logout functions
    function confirmLogout() {
      document.getElementById('logoutModal').classList.remove('hidden');
    }

    function hideLogoutModal() {
      document.getElementById('logoutModal').classList.add('hidden');
    }

    function submitLogout() {
      document.getElementById('logoutForm').submit();
    }

    // Close mobile sidebar when clicking outside
    document.getElementById('mobileSidebar')?.addEventListener('click', function(e) {
      if (e.target === this) {
        this.classList.add('hidden');
      }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-hide flash messages after 5 seconds
      setTimeout(() => {
        document.querySelectorAll('[class*="bg-"]').forEach(el => {
          if (el.textContent.includes(session('success') || '') || el.textContent.includes(session('error') ||
              '')) {
            el.remove();
          }
        });
      }, 5000);
    });
  </script>
</body>

</html>
