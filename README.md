# Laravel Klinik Project

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Project ini dibuat untuk memenuhi tugas akhir mata kuliah Pemrograman Berbasis Web 2. 
Pada aplikasi ini kita akan membuat fitur tambah, tampil, ubah, dan hapus data pasien, data daftar, dan data poli. Terdapat pula halaman login multi-role yang dibuat dengan Laravel Breeze untuk create & register user.

## Requirement

Project ini menggunakan Laravel versi 11. Pastikan PHP yang terinstal di perangkat adalah PHP versi 8.2 atau lebih baru. Jika kalian sebelumnya menggunakan PHP versi 8.1 atau lebih rendah, silakan update Composer dan PHP.

## How to Install

1. Clone repository ini:
   ```bash
   git clone https://github.com/yourusername/laravel-klinik-project.git
   ```
2. Masuk ke direktori project:
   ```bash
   cd laravel-klinik-project
   ```
3. Install dependency menggunakan Composer:
   ```bash
   composer install
   ```
4. Install dependency frontend (jika ada):
   ```bash
   npm install
   ```
5. Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Konfigurasi database dan pengaturan lainnya di file `.env`.

6. Generate application key:
   ```bash
   php artisan key:generate
   ```
7. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
8. (Opsional) Jalankan seeder untuk mengisi data awal:
   ```bash
   php artisan db:seed
   ```
9. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

Aplikasi dapat diakses di `http://localhost:8000`.

## Features

- CRUD data pasien
- CRUD data daftar
- CRUD data poli
- Login multi-role dengan Laravel Breeze
- Dashboard modern menggunakan template Modernize
- Pencarian data menggunakan package [searchable](https://github.com/nicolaslopezj/searchable)

## Alat dan Dependensi

- **Framework**: Laravel 11
- **PHP**: Minimal versi 8.2
- **Template**: Modernize
- **Authentication**: Laravel Breeze
- **Paket tambahan**: Nicolas Lopez Searchable

## Alat dan Dependensi

## Dokumentasi & Cara menggunakan

## License

**Free Software, Hell Yeah!**
