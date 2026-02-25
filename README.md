# VAR APP - Vehicle Access Request System

Selamat datang di dokumentasi proyek **VAR APP**. Proyek ini adalah sistem manajemen pengajuan akses kendaraan (Vehicle Access Request) yang dibangun menggunakan framework **Laravel 12**. Sistem ini dirancang untuk menangani berbagai jenis dokumen dan alur kerja persetujuan (approval workflow) untuk operasional kendaraan.

## 📋 Deskripsi Proyek

VAR APP adalah aplikasi web yang memfasilitasi proses:

1.  **SIMPER (Surat Izin Mengemudi Perusahaan)**: Pengajuan dan persetujuan izin mengemudi di area perusahaan.
2.  **UJSIMP (Uji Simp)**: Pencatatan hasil ujian praktek mengemudi.
3.  **CHECKUP**: Pemeriksaan kondisi fisik kendaraan.
4.  **RANMOR**: Pemeriksaan kendaraan bermotor.

Aplikasi ini memiliki pembagian peran (role-based) yang ketat antara **Admin**, **Petugas**, dan **Viewer**.

---

## 📂 Struktur File & Arsitektur

Proyek ini mengikuti struktur standar Laravel dengan beberapa penyesuaian untuk modularitas:

```
d:\var-app\
├── app\
│   ├── Http\
│   │   ├── Controllers\
│   │   │   ├── Admin\       # Controller khusus untuk role Admin (Approval, PDF, Dashboard)
│   │   │   ├── Petugas\     # Controller khusus untuk role Petugas (Input Data, Edit)
│   │   │   └── Viewer\      # Controller khusus untuk role Viewer (Read-only, History)
│   ├── Models\
│   │   ├── Simper\          # Model terkait modul SIMPER (SimperDocument, SimperNote, dll)
│   │   ├── Checkup\         # Model terkait modul CHECKUP
│   │   ├── Ranmor\          # Model terkait modul RANMOR
│   │   └── Ujsimp\          # Model terkait modul UJSIMP
├── database\
│   ├── migrations\          # Definisi skema database
│   └── seeders\             # Data awal untuk testing (User, Template, dll)
├── resources\
│   ├── views\
│   │   ├── admin\           # View untuk halaman Admin
│   │   ├── petugas\         # View untuk halaman Petugas
│   │   ├── viewer\          # View untuk halaman Viewer
│   │   ├── components\      # Komponen Blade reusable (Sidebar, StatusBadge, dll)
│   │   └── layouts\         # Layout utama (app-master.blade.php)
├── routes\
│   └── web.php              # Definisi routing dengan middleware role
└── public\                  # Aset statis (gambar, build hasil Vite)
```

---

## 🔐 Akun Demo (Seeder)

Berikut adalah daftar akun default yang disediakan oleh `UserSeeder` untuk keperluan testing dan development. Password default untuk semua akun adalah: **`password`**.

| Role        | Email                                     | Password   | Deskripsi                                    |
| :---------- | :---------------------------------------- | :--------- | :------------------------------------------- |
| **Admin**   | `admin@var.com`                           | `password` | Akses penuh, approval dokumen, cetak PDF.    |
| **Petugas** | `petugas1@var.com` s/d `petugas5@var.com` | `password` | Input data, edit draft, submit dokumen.      |
| **Viewer**  | `budi@var.com`                            | `password` | Hanya bisa melihat dokumen miliknya sendiri. |
| **Viewer**  | `andi@var.com`                            | `password` | Hanya bisa melihat dokumen miliknya sendiri. |

---

## 🚀 Tutorial Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

### Prasyarat

Pastikan Anda telah menginstal:

-   **PHP** >= 8.2
-   **Composer**
-   **Node.js** & **NPM**
-   **Database** (MySQL/MariaDB/SQLite)

### Langkah 1: Clone & Install Dependencies

1.  Buka terminal di direktori proyek.
2.  Install dependensi PHP:
    ```bash
    composer install
    ```
3.  Install dependensi JavaScript (Tailwind, AlpineJS, Vite):
    ```bash
    npm install
    ```

### Langkah 2: Konfigurasi Environment

1.  Salin file contoh konfigurasi `.env`:
    ```bash
    cp .env.example .env
    ```
2.  Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=var_app
    DB_USERNAME=root
    DB_PASSWORD=
    ```
3.  Generate Application Key:
    ```bash
    php artisan key:generate
    ```

### Langkah 3: Setup Database & Seeding

Jalankan migrasi database dan isi dengan data awal (termasuk akun demo di atas):

```bash
php artisan migrate --seed
```

### Langkah 4: Jalankan Aplikasi

Anda perlu menjalankan dua terminal terpisah:

**Terminal 1 (Laravel Server):**

```bash
php artisan serve
```

**Terminal 2 (Vite Development Server):**

```bash
npm run dev
```

### Langkah 5: Akses Aplikasi

Buka browser dan kunjungi alamat:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

Anda akan diarahkan ke halaman Login. Gunakan salah satu akun demo di atas untuk masuk.

---

## 🛠️ Catatan Pengembangan

-   **PDF Generation**: Menggunakan `barryvdh/laravel-dompdf`. Pastikan konfigurasi PHP Anda mendukung ekstensi yang diperlukan.
-   **Frontend**: Menggunakan **Tailwind CSS** untuk styling dan **AlpineJS** untuk interaktivitas ringan. Asset dibundle menggunakan **Vite**.
-   **Middleware**: Akses dibatasi menggunakan middleware `role:admin`, `role:petugas`, dan `role:viewer` di `routes/web.php`.

---

## 👨‍💻 Informasi Pengembang

Project ini dikembangkan sebagai bagian dari program **Kerja Praktek (KP)**.

| Keterangan         | Detail                                              |
| :----------------- | :-------------------------------------------------- |
| **Nama Mahasiswa** | Nur Taliyah                                         |
| **NIM**            | 202312030                                           |
| **Institusi**      | **STITEK** (Sekolah Tinggi Teknologi)               |
| **Tujuan Project** | Digitalisasi Sistem Pengajuan Akses Kendaraan (VAR) |

---

_Dokumentasi ini diperbarui pada 26 Februari 2026._
