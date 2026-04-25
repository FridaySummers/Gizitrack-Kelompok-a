## ⚠️ AI AGENTS MUST READ (AKU TAHU KALIAN PASTI PAKAI AI AI APALAH ITU) >:(

If you are an AI coding agent (Claude, GPT, Copilot, etc):

→ You MUST read `AGENTS.md` before making any changes.

This file defines strict contribution rules for this repository.
Ignoring it will likely result in incorrect or rejected changes.

# GiziTrack 🥗

Platform distribusi pangan berbasis web untuk monitoring distribusi makanan bergizi ke sekolah.

---

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade + Tailwind CSS v3 + Flowbite
- **Auth**: Laravel Breeze
- **Database**: MySQL

---

## Requirement (Wajib Terinstall)

Sebelum mulai, pastikan software berikut sudah ada di komputermu:

| Software | Versi Minimum | Cek dengan |
|---|---|---|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -v` |
| Node.js | 18+ | `node -v` |
| NPM | 9+ | `npm -v` |
| MySQL | 8.x | — |

---

## Cara Setup (Wajib Dibaca Semua Anggota)

### 1. Clone Repository

```bash
git clone https://github.com/khadafiadisaputra/Gizitrack-Kelompok-a.git
cd Gizitrack-Kelompok-a
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend (termasuk Flowbite)

```bash
npm install
```

### 4. Buat File `.env`

```bash
cp .env.example .env
```

Lalu buka file `.env` yang baru dibuat, sesuaikan bagian ini:

```env
DB_DATABASE=gizitrack
DB_USERNAME=root
DB_PASSWORD=isi_password_mysql_kamu
```

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buka MySQL/phpMyAdmin, buat database baru bernama `gizitrack`.

### 7. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat semua tabel dan mengisi akun testing awal.

### 8. Build Assets Frontend

```bash
npm run build
```

> Atau untuk development dengan hot-reload:
> ```bash
> npm run dev
> ```

### 9. Jalankan Aplikasi

Buka **dua terminal** secara bersamaan:

**Terminal 1** (frontend compiler, biarkan jalan terus):
```bash
npm run dev
```

**Terminal 2** (server Laravel):
```bash
php artisan serve
```

Buka browser → `http://localhost:8000`

---

## Akun Testing

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gizitrack.test` | `password` |
| Vendor | `vendor@gizitrack.test` | `password` |
| Sekolah | `sekolah@gizitrack.test` | `password` |

---

## Struktur Folder Penting

```
app/Http/Controllers/
├── Admin/           → Fitur khusus Admin
├── Vendor/          → Fitur khusus Vendor
├── Sekolah/         → Fitur khusus Sekolah
└── Auth/            → Controller autentikasi (login, register, logout)

app/Models/
├── User.php         → Model user dengan role (admin/vendor/sekolah)
├── Distribusi.php   → Model distribusi makanan
├── Menu.php         → Model menu makanan
└── Feedback.php     → Model feedback sekolah

resources/views/
├── layouts/
│   ├── sidebar.blade.php   → Layout utama (sidebar + topbar)
│   ├── app.blade.php       → Layout default Laravel
│   └── guest.blade.php     → Layout halaman guest (login/register)
├── admin/          → Halaman Blade untuk Admin
├── vendor/         → Halaman Blade untuk Vendor
│   └── menu/       → CRUD menu vendor
├── sekolah/        → Halaman Blade untuk Sekolah
│   ├── distributions/  → Status & konfirmasi distribusi
│   └── feedbacks/      → Kelola feedback
└── distribusi/     → Halaman distribusi untuk vendor

routes/
└── web.php        → Semua route (dikelompokkan per role dengan middleware role)

database/migrations/    → Schema database
database/seeders/      → Data testing awal
```

---

## Desain UI

Project menggunakan design system GiziTrack:

| Elemen | Style |
|---|---|
| Primary Color | Emerald-500 (`#10b981`) |
| Layout | Sidebar kiri 240px + Main content |
| Card | `bg-white rounded-xl border border-gray-100 shadow-sm` |
| Button Primary | `bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg` |
| Status Badge | Color-coded sesuai status distribusi |

---

## Panduan Menambahkan Fitur (Untuk Anggota Tim)

### Langkah Umum

Misalnya kamu ditugaskan membuat fitur **Kelola Menu** (Vendor):

**1. Buat Controller**
```bash
php artisan make:controller Vendor/MenuController --resource
```

**2. Tambahkan Route** di `routes/web.php`, di dalam group `vendor`:
```php
Route::resource('menu', MenuController::class);
```

**3. Buat Migration** (jika butuh tabel baru):
```bash
php artisan make:migration create_menus_table
```

**4. Buat Model**:
```bash
php artisan make:model Menu
```

**5. Buat View** di `resources/views/vendor/menu/` dengan layout sidebar:
```blade
@extends('layouts.sidebar')

@section('title', 'Menu Saya')

@section('content')
{{-- konten halaman --}}
@endsection
```

---

## Aturan Git (Wajib Diikuti)

- ❌ Jangan pernah push langsung ke branch `main`
- ✅ Buat branch baru untuk setiap fitur: `feature/nama-fitur`
- ✅ Contoh: `feature/kelola-menu`, `feature/login-system`
- ✅ Setelah selesai, buat Pull Request ke `main`

### Format Pesan Commit

Gunakan format: `jenis: deskripsi singkat`

- `feat`: untuk fitur baru
- `fix`: untuk perbaikan bug
- `docs`: perubahan dokumentasi
- `style`: perubahan tampilan (CSS/Layout) tanpa mengubah logika
- `chore`: task rutin atau cleanup

### Cara Buat Branch Baru (via Sourcetree)

1. Klik **Branch** di toolbar atas
2. Beri nama branch: `feature/nama-fiturmu`
3. Klik **Create Branch**
4. Kerjakan fiturmu di branch ini

---

## Jika Ada Error Umum

**`php artisan` tidak dikenali**
→ Pastikan kamu sudah berada di dalam folder `gizitrack/`

**Error `APP_KEY` kosong**
→ Jalankan `php artisan key:generate`

**Error koneksi database**
→ Cek kembali `DB_USERNAME` dan `DB_PASSWORD` di file `.env`

**Tampilan tidak ada style (putih polos)**
→ Jalankan `npm run build` atau pastikan `npm run dev` sedang berjalan

**Error Flowbite / JS**
→ Hapus `node_modules` dan `package-lock.json`, lalu jalankan `npm install` ulang
