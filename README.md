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
- Enkripsi data sensitif

### 📍 Presensi Berbasis Lokasi
- Validasi GPS dengan radius tertentu
- Deteksi koordinat menggunakan HTML5 Geolocation API
- Validasi jarak real-time

### ⏰ Manajemen Jadwal
- Pengaturan jam masuk & pulang
- Toleransi keterlambatan configurable

### 📊 Pelaporan & Analitik
- Dashboard statistik kehadiran
- Riwayat absensi per karyawan
- Laporan bulanan/tahunan
- Ekspor data

### 👥 Manajemen Karyawan
- CRUD data karyawan lengkap
- Riwayat kehadiran individu

## 🛠️ Teknologi

### Backend
- **Framework:** Laravel 12.x
- **PHP Version:** 8.1+
- **Database:** MySQL 8.0+

### Frontend
- **CSS Framework:** Tailwind CSS 4.x
- **JavaScript:** Vanilla JS
- **Icons:** Font Awesome 6
- **Charts:** Chart.js
- **Maps:** Leaflet.js

### Development Tools
- **Package Manager:** Composer, NPM
- **Version Control:** Git
- **Local Server:** Laragon

## 📋 Persyaratan Sistem

### Server Requirements
- PHP 8.1 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.4+
- Web Server (Apache/Nginx)
- Composer
- Node.js 16.x atau lebih tinggi
- NPM 8.x atau lebih tinggi

## 🚀 Instalasi

```bash
# Clone repository dari GitHub
git clone https://github.com/username/sistem-management-absensi.git

# Masuk ke direktori project
cd sistem-management-absensi

# Hapus .example pada pada nama file .env.example sehingga menjadi file .env

# Generate Key Aplication
php artisan key:generate

# Install JavaScript dependencies 
npm install

# Install PHP dependencies
composer install

# Jalankan migrasi untuk tabel jadwal absensi
php artisan migrate --path=database/migrations/2025_12_25_112620_create_jadwal_absensi_table.php

# Jalankan migrasi untuk membuat semua tabel
php artisan migrate

# Jalankan seed untuk mengisi data pada tabel
php artisan db:seed

# Jalankan aplikasi
php artisan serve
