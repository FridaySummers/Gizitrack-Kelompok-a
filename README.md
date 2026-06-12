# 🥗 GiziTrack - Sistem Informasi Distribusi Pangan Terintegrasi

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

**GiziTrack** adalah platform tata kelola dan monitoring distribusi makanan bergizi gratis yang dirancang dengan standar Enterprise SaaS. Sistem ini memastikan transparansi, akuntabilitas, dan efisiensi dalam seluruh rantai pasok logistik gizi, mulai dari pengelolaan menu oleh Vendor hingga verifikasi penerimaan oleh pihak Sekolah.

---

## 🚀 Fitur Utama

Sistem ini telah melewati fase pengembangan intensif dengan fokus pada keamanan tingkat tinggi dan analisis data real-time:

-   **🛡️ Keamanan & Autentikasi Berlapis**:
    -   Sistem Middleware Role-Based Access Control (RBAC) yang sangat ketat.
    -   **2-Times Password Verification**: Proteksi ekstra untuk rute sensitif (pembuatan user, update profil).
    -   **Super Admin Impersonation**: Memungkinkan administrator untuk meninjau sesi user lain tanpa kredensial, terdokumentasi secara aman.
-   **📊 Dashboard Analytics Real-Time**:
    -   Visualisasi data menggunakan Chart.js untuk memantau tren distribusi.
    -   Statistik performa (Success Rate) dan pemantauan kendala/komplain secara langsung.
-   **🏫 Pusat Resolusi Sekolah**:
    -   Modul verifikasi penerimaan logistik (Diterima, Diterima Sebagian, Komplain).
    -   Feedback sistem untuk menjamin kualitas layanan vendor.
-   **📦 Manajemen Vendor & Logistik**:
    -   Pengelolaan menu gizi dengan kalkulasi kalori (Integrasi TKPI).
    -   Pelacakan koordinat GPS (Live Tracking) untuk armada pengiriman.
-   **📄 Pelaporan Enterprise**:
    -   Ekspor data otomatis dalam format **PDF** untuk arsip fisik.
    -   Ekspor data **CSV** untuk kebutuhan analisis data eksternal.

---

## 🛠️ Tech Stack

-   **Core Framework**: Laravel 11 (PHP 8.2+)
-   **Frontend Engine**: Tailwind CSS & Flowbite (Modern SaaS UI)
-   **Database**: MySQL / MariaDB
-   **Asset Bundler**: Vite
-   **Library Tambahan**: DomPDF, Maatwebsite Excel, Chart.js, Alpine.js.

---

## ⚙️ Panduan Instalasi & Deployment

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Server

### Langkah-langkah Instalasi
1.  **Clone Repositori**:
    ```bash
    git clone https://github.com/FridaySummers/gizitrack-kelompok-a.git
    cd gizitrack-kelompok-a
    ```
2.  **Instalasi Dependensi**:
    ```bash
    composer install
    npm install
    ```
3.  **Konfigurasi Lingkungan**:
    Salin file `.env.example` menjadi `.env` dan sesuaikan kredensial database Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Catatan: Untuk production, pastikan `APP_ENV=production` dan `APP_DEBUG=false`.*

4.  **Migrasi & Seeding**:
    ```bash
    php artisan migrate --seed
    ```

5.  **Optimasi Akhir (Production Ready)**:
    Jalankan script optimasi yang telah disediakan untuk me-cache konfigurasi dan membangun aset frontend.
    ```bash
    chmod +x optimize.sh
    ./optimize.sh
    ```

---

## 👥 Kelompok A - SI4710
Sistem ini dikembangkan sebagai solusi inovatif dalam manajemen logistik pangan nasional.
| Nama Anggota |
| :--- |
| **Muhammad Fadhilah** |
| **Muhammad Khadafi Adi Saputra** |
| **Kirana Amelia Maharani** |
| **Sanjaya Fathur Rahman** |
| **Adlan Kholaif Daibain** |
| **Nadia Miranda** |

&copy; 2026 **GiziTrack System**. Versi 1.0.0-Stable.
