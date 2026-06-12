# 🥗 GiziTrack - Sistem Informasi Distribusi Pangan Terintegrasi

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

**GiziTrack** adalah platform tata kelola dan monitoring distribusi makanan bergizi gratis yang dirancang dengan standar Enterprise SaaS. Sistem ini memastikan transparansi, akuntabilitas, dan efisiensi dalam seluruh rantai pasok logistik gizi, mulai dari pengelolaan menu oleh Vendor hingga verifikasi penerimaan oleh pihak Sekolah.

---

## 🚀 Fitur Utama

Sistem ini telah melewati fase pengembangan intensif dengan fokus pada keamanan tingkat tinggi, stabilitas backend, dan analisis data real-time:

-   **🛡️ Keamanan & Autentikasi Berlapis**:
    -   Sistem Middleware Role-Based Access Control (RBAC) yang sangat ketat dengan pembatasan *Super Admin Access*.
    -   **2-Times Password Verification**: Proteksi ekstra untuk rute sensitif (pembuatan user, update profil).
    -   **Audit Trail & Admin Interventions**: Arsitektur pelacakan jejak aktivitas serta fitur Intervensi Darurat untuk pembatalan/revisi entri data oleh Admin.
-   **📊 Dashboard Analytics Real-Time**:
    -   Visualisasi data menggunakan Chart.js untuk memantau tren distribusi, visualisasi timeline pengiriman, dan backend logic metrik KPI.
-   **🏫 Pusat Resolusi Sekolah**:
    -   Modul verifikasi penerimaan logistik (Diterima, Diterima Sebagian, Komplain) yang dibangun menggunakan isolasi *Database Transaction* (`try-catch`) untuk keamanan data.
-   **📦 Manajemen Vendor & Logistik**:
    -   Pengelolaan siklus CRUD menu gizi dengan integrasi form TKPI (kalkulasi kalori) dan otorisasi kustom via *Laravel Policy*.
    -   Pelacakan koordinat harian secara waktu nyata (*Live Tracking*) serta otomatisasi manifes status pengiriman.
-   **📄 Pelaporan Enterprise & Automated Testing**:
    -   Ekspor data otomatis (PDF/CSV) untuk analisis eksternal.
    -   Integrasi pengujian otomatis *End-to-End* skala penuh berbasis browser menggunakan **Laravel Dusk** untuk pengujian skenario positif dan negatif.

---

## 🛠️ Tech Stack

-   **Core Framework**: Laravel 11 (PHP 8.2+)
-   **Frontend Engine**: Tailwind CSS & Flowbite (Modern SaaS UI)
-   **Database**: MySQL / MariaDB
-   **Asset Bundler**: Vite
-   **Library Tambahan**: DomPDF, Maatwebsite Excel, Chart.js, Alpine.js, Laravel Dusk.

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

    > **Catatan:** Untuk production, pastikan `APP_ENV=production` dan `APP_DEBUG=false`.

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

## 👥 Kelompok A - SI4710: Highlight Fitur & Kontribusi Tim

Sistem ini dikembangkan secara kolaboratif melalui pembagian *Product Backlog Item* (PBI) spesifik pada setiap anggota:

| Anggota Tim & GitHub | Cakupan PBI | Fokus Kontribusi & Modul Utama |
| :--- | :--- | :--- |
| **Sanjaya Fathur Rahman**<br>[@FridaySummers](https://github.com/FridaySummers) | PBI 19-22, 36-38 | **UI Overhaul & Pusat Resolusi** — Merombak total visual UI dashboard/sidebar, mengembangkan arsitektur backend aman via *Database Transaction* untuk modul komplain sekolah, dan memimpin investigasi penanganan galat `SQLSTATE` & *Code Cleanup*. |
| **Muhammad Khadafi Adi Saputra**<br>[@khadafiadisaputra](https://github.com/khadafiadisaputra) | PBI 11-14, 28-30, 32 | **Dashboard Analytics & Menu Vendor** — Implementasi CRUD Menu Vendor, form TKPI, otorisasi kustom (*Laravel Policy*), backend logic metrik KPI, grafik Chart.js, ekspor laporan, serta memimpin penyusunan otomatisasi pengujian browser. |
| **Muhammad Fadhilah**<br>[@Fadilah170](https://github.com/Fadilah170) | PBI 7-10, 27, 43-44 | **Account Management & Auth** — Membangun fitur registrasi entitas dengan skema keamanan *2-Times Password Verification*, sistem peringkat/leaderboard skor vendor berbasis resolusi, manajemen CRUD akun oleh admin, dan penulisan berkas unit testing akun. |
| **Adlan Kholaif Daibain**<br>[@Adlankh](https://github.com/Adlankh) | PBI 3-6, 40-42 | **Profile Management & Admin Interventions** — Fitur Intervensi Darurat (pembatalan/revisi entri data oleh Admin), CRUD admin operasional oleh Super Admin, arsitektur *Audit Trail* (`created_by`), dan pembatasan middleware Super Admin Access. |
| **Kirana Amelia Maharani**<br>[@kiranaameliaa](https://github.com/kiranaameliaa) | PBI 17-18, 33-35 | **Logistics & Request Change** — Mengembangkan fitur pelacakan harian secara waktu nyata (*live tracking*), otomatisasi manifes status pengiriman (Otomatis Dikirim), sistem *Request Change* menu dari sisi vendor, dan riwayat logistik. |
| **Nadia Miranda**<br>[@Nadiamiranda07](https://github.com/Nadiamiranda07) | PBI 16, 37-39 | **Dashboard Monitoring & Visual Timeline** — Stabilisasi komponen visual, perancangan dashboard monitoring performa distribusi, visualisasi timeline pengiriman di halaman sekolah, serta pembaruan UI harian pada panel vendor. |

> **Automated Dusk Testing (Bersama):** Seluruh anggota tim berkontribusi dalam integrasi suite pengujian otomatis *End-to-End* berskala penuh berbasis browser menggunakan **Laravel Dusk** untuk memastikan seluruh rute PBI fungsional teruji secara aman.

---

&copy; 2026 **GiziTrack System**. Versi 1.0.0-Stable.
