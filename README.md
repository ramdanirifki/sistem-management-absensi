# Sistem Management Absensi

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Sistem Management Absensi berbasis web yang dibangun dengan Laravel untuk mengelola kehadiran karyawan dengan fitur presensi berbasis lokasi (GPS), jadwal kerja fleksibel, dan pelaporan lengkap.

## 📋 Daftar Isi
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi Database](#-konfigurasi-database)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Struktur Database](#-struktur-database)
- [Default Login](#-default-login)
- [Cara Penggunaan](#-cara-penggunaan)
- [Troubleshooting](#-troubleshooting)

## ✨ Fitur Utama

### 🔐 Autentikasi & Keamanan
- Login multi-role (Admin & Karyawan)
- Proteksi route berdasarkan permission
- Validasi sesi dan timeout otomatis
- Enkripsi data sensitif

### 📍 Presensi Berbasis Lokasi
- Validasi GPS dengan radius tertentu
- Deteksi koordinat menggunakan HTML5 Geolocation API
- Pengaturan multiple lokasi presensi
- Validasi jarak real-time

### ⏰ Manajemen Jadwal
- Jadwal kerja fleksibel per karyawan
- Pengaturan jam masuk & pulang
- Toleransi keterlambatan configurable
- Shift kerja (pagi, siang, malam)

### 📊 Pelaporan & Analitik
- Dashboard statistik kehadiran
- Riwayat absensi per karyawan
- Laporan bulanan/tahunan
- Ekspor data ke Excel/PDF
- Grafik visualisasi data

### 👥 Manajemen Karyawan
- CRUD data karyawan lengkap
- Upload foto profil
- Riwayat kehadiran individu
- Notifikasi & reminder

## 🛠️ Teknologi

### Backend
- **Framework:** Laravel 10.x
- **PHP Version:** 8.1+
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Sanctum
- **API:** RESTful API

### Frontend
- **CSS Framework:** Tailwind CSS 4.x
- **JavaScript:** Vanilla JS
- **Icons:** Font Awesome 6
- **Charts:** Chart.js
- **Maps:** Leaflet.js

### Development Tools
- **Package Manager:** Composer, NPM
- **Version Control:** Git
- **Local Server:** Laragon/XAMPP

## 📋 Persyaratan Sistem

### Server Requirements
- PHP 8.1 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.4+
- Web Server (Apache/Nginx)
- Composer
- Node.js 16.x atau lebih tinggi
- NPM 8.x atau lebih tinggi

### PHP Extensions
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## 🚀 Instalasi

### Langkah 1: Clone Repository
```bash
# Clone repository dari GitHub
git clone https://github.com/username/sistem-management-absensi.git

# Masuk ke direktori project
cd sistem-management-absensi
