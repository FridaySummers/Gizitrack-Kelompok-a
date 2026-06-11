# 🥗 GiziTrack - Enterprise Logistics Ecosystem

**GiziTrack** adalah platform tata kelola dan monitoring distribusi makanan bergizi gratis yang dirancang dengan standar Enterprise SaaS. Sistem ini memastikan transparansi, akuntabilitas, dan efisiensi dalam rantai pasok logistik gizi dari Vendor hingga ke Sekolah.

---

## 🛠️ Requirement (Wajib Terinstall)

| Software | Versi Minimum | Cek dengan |
|---|---|---|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -v` |
| Node.js | 18+ | `node -v` |
| NPM | 9+ | `npm -v` |
| MySQL | 8.x | — |

---

## 🚀 Cara Setup

### 1. Persiapan Awal
```bash
git clone https://github.com/khadafiadisaputra/Gizitrack-Kelompok-a.git
cd Gizitrack-Kelompok-a
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database
Buat database bernama `gizitrack` di MySQL Anda, lalu sesuaikan `.env`:
```env
DB_DATABASE=gizitrack
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Migrasi & Build
```bash
php artisan migrate --seed
npm run build
```

---

## 🔑 Akun Testing (Development Only)

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `superadmin@gizitrack.test` | `password` |
| **Admin** | `admin@gizitrack.test` | `password` |
| **Vendor** | `vendor@gizitrack.test` | `password` |
| **Sekolah** | `sekolah@gizitrack.test` | `password` |

---

## 📂 Struktur Folder Penting

```
app/
├── Exports/         → Logika ekspor Excel (Maatwebsite Excel)
├── Http/Controllers/
│   ├── Admin/       → Analytics & Global Distributions
│   ├── SuperAdmin/  → Account Management & Impersonation
│   ├── Vendor/      → Dashboard & Menu Management
│   └── Sekolah/     → Monitoring & Feedback
├── Models/          → Distribusi, User, Menu, Feedback, RequestChange

resources/views/
├── Admin/           → Portal Admin & Analytics
├── super_admin/     → Portal Super Admin
├── vendor/          → Portal Vendor
├── sekolah/         → Portal Sekolah
├── layouts/         → Sidebar Enterprise & App Wrappers
└── auth/            → Modern Split-Screen Login Pages
```

---

## 🛡️ Aturan Git & Standar Kode

- **Prefix Commit**: `[GIZITRACK-XX]` (Sesuai ID Task)
- **Standard**: Laravel Pint (PHP) & Tailwind Standalone
- **Testing**: Gunakan **Laravel Dusk** untuk pengujian UI otomatis. Pastikan selector `dusk="..."` tidak dihapus saat modifikasi view.

---
*GiziTrack - Healthy Food Logistics, Managed Professionally.*
