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
- PHP 8.2 atau diatasnya
- MySQL (bisa menggunakan XAMPP atau Laragon)
- Composer
- IDE (VS Code, Sublime Text)
Project ini menggunakan Laravel versi 11. Pastikan PHP yang terinstal di perangkat adalah PHP versi 8.2 atau lebih baru. Jika kalian sebelumnya menggunakan PHP versi 8.1 atau lebih rendah, silakan update Composer dan PHP.

Login default : 
- Email : myadmin1@gmail.com
- Password : 12345678
- 
## How to Install

1. Clone repository ini menggunakan terminal atau git bash:
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
4. Install dependency frontend :
   ```bash
   npm install
   ```
5. Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
6. Buat database dengan nama 'klinik_db" atau lainnya. Konfigurasi database dan pengaturan lainnya di file `.env`.
   lakukan pengecekan koneksi:
   ```bash
   php artisan db:monitor
   ```
   Jika muncul OK maka koneksi ke database berhasil, Jika error tanyakan Chatgpt

7. Generate application key:
   ```bash
   php artisan key:generate
   ```
8. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
9. (Opsional) Jalankan seeder untuk mengisi data awal:
   ```bash
   php artisan db:seed
   ```
10. Jalankan server :
   ```bash
   php artisan serve
   ```
   
Website dapat diakses di `http://localhost:8000`.

## Features

- Login, register multi-role dengan Laravel Breeze
- Verifikasi Email menggunakan smtp
- CRUD data pasien
- CRUD data daftar
- CRUD data poli
- Laporan data Pasien & Pendaftaran 
- Dashboard modern menggunakan template Modernize
- Pencarian data menggunakan package [searchable](https://github.com/nicolaslopezj/searchable)

## Alat dan Dependensi

| Plugin | README |
| ------ | ------ |
| Laragon | [https://laragon.org/download/] |
| Composer | [https://getcomposer.org/download/] |
| Laravel | [https://laravel.com/docs/11.x/installation] |
| Modernize |https://themewagon.com/themes/modernize/ |

## Dokumentasi & Cara menggunakan

## License

**Free Software, Hell Yeah!**
