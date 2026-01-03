<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Sistem Absensi Pegawai</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          keyframes: {
            fadeInUp: {
              '0%': {
                opacity: '0',
                transform: 'translateY(20px)'
              },
              '100%': {
                opacity: '1',
                transform: 'translateY(0)'
              },
            },
            bounceSlow: {
              '0%, 100%': {
                transform: 'translateY(-5%)',
                animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)'
              },
              '50%': {
                transform: 'translateY(0)',
                animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)'
              },
            },
            shake: {
              '0%, 100%': {
                transform: 'translateX(0)'
              },
              '10%, 30%, 50%, 70%, 90%': {
                transform: 'translateX(-5px)'
              },
              '20%, 40%, 60%, 80%': {
                transform: 'translateX(5px)'
              }
            }
          },
          animation: {
            'fade-in-up': 'fadeInUp 0.7s ease-out',
            'bounce-slow': 'bounceSlow 3s infinite',
            'shake': 'shake 0.5s ease-in-out'
          }
        }
      }
    }
  </script>
</head>

<body
  class="my-7 font-sans antialiased min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center px-6">
  <div
    class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-white/5 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/10">

    <!-- Left Side - Branding -->
    <div
      class="hidden md:flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-600 p-10 relative overflow-hidden">
      <!-- Animated background elements -->
      <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/10 rounded-full translate-x-1/3 translate-y-1/3"></div>

      <div class="relative text-white text-center z-10">
        <div class="w-40 h-40 mx-auto mb-6 flex items-center justify-center bg-white/20 rounded-full shadow-2xl">
          <i class="fas fa-fingerprint text-6xl"></i>
        </div>
        <h2 class="text-3xl font-bold tracking-wide mb-3">Sistem Absensi Digital</h2>
        <p class="text-sm text-indigo-100 mb-6 font-medium">
          Kelola kehadiran pegawai dengan cepat, akurat, dan terintegrasi
        </p>
        <div class="space-y-2 text-left">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-300 mr-2"></i>
            <span class="text-sm">Absensi dengan GPS (Lokasi)</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-300 mr-2"></i>
            <span class="text-sm">Monitor Kehadiran Real-time</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-300 mr-2"></i>
            <span class="text-sm">Statistik Hadir/Terlambat/Tidak Hadir</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-300 mr-2"></i>
            <span class="text-sm">Riwayat Absensi Detail</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-300 mr-2"></i>
            <span class="text-sm">Catatan dan Keterangan Absensi</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="flex items-center justify-center p-8 md:p-12">
      <div class="bg-white/95 backdrop-blur-md w-full max-w-md rounded-2xl shadow-2xl p-8 animate-fade-in-up">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
            <i class="fas fa-user-clock text-3xl text-indigo-600"></i>
          </div>
          <h1 class="text-3xl font-bold text-slate-900">Masuk ke Sistem</h1>
          <p class="text-slate-500 mt-2 text-sm">Silakan login dengan akun yang terdaftar</p>
        </div>

        <!-- Error/Success Messages -->
        @if ($errors->any())
          <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r animate-shake">
            <div class="flex items-center">
              <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
              <div>
                <p class="text-red-700 font-medium">Login Gagal</p>
                <p class="text-red-600 text-sm mt-1">{{ $errors->first() }}</p>
              </div>
            </div>
          </div>
        @endif

        @if (session('status'))
          <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r">
            <div class="flex items-center">
              <i class="fas fa-check-circle text-green-500 mr-3"></i>
              <p class="text-green-700">{{ session('status') }}</p>
            </div>
          </div>
        @endif

        <!-- Login Form -->
        <form class="space-y-5" action="{{ route('login') }}" method="POST" id="loginForm">
          @csrf

          <!-- Email Field -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
              <i class="fas fa-envelope mr-2 text-indigo-500"></i>Alamat Email
            </label>
            <input type="email" name="email" placeholder="nama@perusahaan.com" required value="{{ old('email') }}"
              class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-slate-800"
              autocomplete="email" autofocus>
          </div>

          <!-- Password Field with Toggle -->
          <div>
            <div class="flex justify-between items-center mb-1">
              <label class="block text-sm font-medium text-slate-700">
                <i class="fas fa-lock mr-2 text-indigo-500"></i>Password
              </label>
            </div>
            <div class="relative">
              <input type="password" name="password" id="password" placeholder="Masukkan password" required
                class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-slate-800"
                autocomplete="current-password">
              <button type="button" id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600 transition-colors">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-2">
            <button type="submit" id="loginButton"
              class="w-full py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 active:scale-[0.98] transition-all duration-200 text-white font-bold shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2">
              <i class="fas fa-sign-in-alt"></i>
              <span>Masuk Sekarang</span>
              <span id="loadingSpinner" class="hidden">
                <i class="fas fa-spinner fa-spin"></i>
              </span>
            </button>
          </div>
        </form>

        <!-- Additional Links -->
        <div class="mt-8 text-center space-y-3">
          <p class="text-sm text-slate-500">
            Lupa password atau belum memiliki akun?
            <span class="text-slate-400">Silahkan hubungi administrator</span>
          </p>

          <!-- System Status -->
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs text-slate-600">Sistem Online • {{ date('H:i') }}</span>
          </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-8 pt-4 border-t border-slate-200">
          <i class="fas fa-shield-alt mr-1"></i>
          Dilindungi dengan enkripsi SSL •
          &copy; {{ date('Y') }} Sistem Absensi Digital v1.0
        </p>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle password visibility
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');

      if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
            '<i class="fas fa-eye-slash"></i>';
        });
      }

      // Form submission loading state
      const loginForm = document.getElementById('loginForm');
      const loginButton = document.getElementById('loginButton');
      const loadingSpinner = document.getElementById('loadingSpinner');

      if (loginForm) {
        loginForm.addEventListener('submit', function() {
          loginButton.disabled = true;
          loginButton.classList.add('opacity-75');
          loadingSpinner.classList.remove('hidden');
        });
      }

      // Auto capitalize first letter of email username
      const emailInput = document.querySelector('input[name="email"]');
      if (emailInput) {
        emailInput.addEventListener('blur', function() {
          const value = this.value;
          if (value && !value.includes('@')) {
            this.value = value.toLowerCase();
          }
        });
      }

      // Enter key to submit
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.target.matches('button, a, [type="submit"]')) {
          const activeElement = document.activeElement;
          if (activeElement && activeElement.form) {
            activeElement.form.requestSubmit();
          }
        }
      });

      // Show browser autofill indicator
      const inputs = document.querySelectorAll('input[autocomplete]');
      inputs.forEach(input => {
        input.addEventListener('animationstart', function(e) {
          if (e.animationName === 'onAutoFillStart') {
            this.parentElement.classList.add('autofilled');
          }
        });
      });
    });

    // Simple shake animation for errors
    function shakeElement(elementId) {
      const element = document.getElementById(elementId);
      if (element) {
        element.classList.add('animate-shake');
        setTimeout(() => {
          element.classList.remove('animate-shake');
        }, 500);
      }
    }
  </script>

  <style>
    /* Custom styles for autofill */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
      -webkit-box-shadow: 0 0 0px 1000px white inset !important;
      -webkit-text-fill-color: #1e293b !important;
      border: 1px solid #6366f1 !important;
    }

    /* Focus styles */
    input:focus {
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Smooth transitions */
    * {
      transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</body>

</html>
