# Balita App

## Prerequisites

Sebelum memulai, pastikan Anda memiliki perangkat berikut:

- **PHP** >= 8.1
- **Composer** - untuk mengelola dependensi PHP
- **Database** (MySQL, SQLite, dll.) - untuk menyimpan data aplikasi

## Langkah-langkah Menjalankan Proyek

1. **Clone Repository**: Clone repositori ke mesin lokal Anda dengan perintah berikut:
   ```bash
   git clone <URL_REPOSITORY>
   ```
   Masuk ke folder repository project
   ```bash
   cd <NAMA_FOLDER_REPOSITORY>

1. **Update Dependencies**: Jalankan perintah berikut untuk memperbarui semua dependensi yang diperlukan oleh proyek:
   ```bash
   composer update

2. **Generate Application Key**: Setelah memperbarui dependensi, Anda perlu menghasilkan kunci aplikasi yang unik dengan perintah berikut:
   ```bash
   php artisan key:generate

3. **Konfigurasi Database**: Buka file .env dan atur konfigurasi database sesuai dengan lingkungan lokal Anda. Temukan bagian berikut dan sesuaikan nilainya:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=root
   DB_PASSWORD=

4. **Jalankan Migrasi**: Setelah mengatur database, jalankan migrasi untuk membuat tabel yang diperlukan dengan perintah berikut:
   ```bash
   php artisan migrate

5. **Buat User Filament**: Jika Anda menggunakan Filament, buat pengguna admin menggunakan perintah berikut:
   ```bash
   php artisan make:filament-user
   ```
   Ikuti instruksi yang diberikan untuk menyelesaikan pembuatan pengguna.

6. **Jalankan Server**: Sekarang, Anda dapat menjalankan server lokal Laravel dengan perintah berikut:
   ```bash
   php artisan serve
   ```
   Secara default, server akan berjalan di http://localhost:8000

7. **Akses Admin**: Untuk mengakses panel admin, tambahkan /admin ke URL server lokal Anda:
   ```bash
   http://localhost:8000/admin
