# EatWise

## Deskripsi Singkat

**EatWise** adalah sebuah platform resep masakan yang dapat diakses melalui **aplikasi mobile** dan **website**. Aplikasi mobile dikembangkan menggunakan Flutter, sedangkan website dan API backend dibangun dengan Laravel. Keduanya terhubung ke API yang sama untuk memastikan konsistensi data dan fungsionalitas di kedua platform. Proyek ini bertujuan untuk menyediakan pengalaman yang kaya fitur bagi para pecinta masak, baik di perangkat mobile maupun desktop.

## Fitur Utama

- **Pencarian Resep**: Temukan resep berdasarkan nama, kategori, atau bahkan budget.  
- **Rekomendasi Cerdas**: Dapatkan rekomendasi resep berdasarkan kesukaan dan riwayat Anda.  
- **Manajemen Resep**: Tambah, edit, dan hapus resep pribadi Anda.  
- **Fitur Sosial**: Berikan rating dan komentar pada resep yang Anda coba.  
- **Chatbot Interaktif**: Dapatkan bantuan dan inspirasi memasak melalui chatbot cerdas.  

## Tech Stack / Dependencies

Proyek ini terdiri dari tiga bagian utama: aplikasi mobile (frontend), website, dan server (backend).

### Frontend (Aplikasi Mobile - Flutter)

| Dependency             | Versi   |
| ---------------------- | ------- |
| flutter                | sdk     |
| iconsax                | ^0.0.8  |
| image_picker           | ^1.0.7  |
| sqflite                | ^2.3.0  |
| path_provider          | ^2.1.1  |
| cupertino_icons        | ^1.0.8  |
| get                    | ^4.7.2  |
| google_fonts           | ^6.2.1  |
| iconify_flutter        | ^0.0.7  |
| http                   | ^1.3.0  |
| flutter_dotenv         | ^5.1.0  |
| get_storage            | ^2.1.1  |
| intl                   | ^0.18.1 |
| cached_network_image   | ^3.2.3  |

### Backend & Website (Laravel)

| Dependency        | Versi    |
| ----------------- | -------- |
| php               | ^8.2     |
| laravel/framework | ^12.0    |
| laravel/sanctum   | ^4.0     |
| laravel/tinker    | ^2.10.1  |

## Instalasi & Setup

Untuk menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

### 1. Backend & Website (Laravel)

```bash
# Clone repositori
git clone https://github.com/fbnajis/eatwise.git

# Masuk ke direktori laravel
cd eatwise/laravel

# Install dependency composer
composer install

# Salin file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Jalankan server pengembangan (untuk API dan Website)
php artisan serve
```

### 2. Frontend (Aplikasi Mobile - Flutter)

```bash
# Buka terminal baru dan masuk ke direktori flutter
cd eatwise/flutter

# Install dependency flutter
flutter pub get

# Jalankan aplikasi
flutter run
```

## Penggunaan

Setelah instalasi selesai, backend dan website akan berjalan di `http://localhost:8000`. Aplikasi Flutter akan ter-install di emulator atau perangkat fisik yang terhubung.

- **Website**: Akses melalui browser di alamat `http://localhost:8000`.  
- **Aplikasi Mobile**: Pastikan untuk mengkonfigurasi koneksi API dari aplikasi Flutter ke server Laravel Anda (`http://localhost:8000/api`).  

## Struktur Folder

```
eatwise/
├── flutter/      # Kode sumber aplikasi mobile Flutter
│   ├── lib/
│   │   ├── app/
│   │   │   ├── modules/ # Fitur-fitur aplikasi
│   │   │   └── routes/  # Konfigurasi routing
│   │   └── main.dart
│   └── pubspec.yaml
└── laravel/      # Kode sumber backend (API) dan website Laravel
    ├── app/
    │   ├── Http/
    │   │   └── Controllers/
    │   └── Models/
    ├── database/
    ├── public/
    ├── resources/
    │   └── views/     # File blade untuk website
    └── routes/
        ├── api.php    # Rute untuk API
        └── web.php    # Rute untuk website
```
