# GiziTrack 🥗

Platform distribusi pangan berbasis web untuk monitoring distribusi makanan bergizi ke sekolah.

---

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade + Tailwind CSS
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
git clone https://github.com/[nama-org]/gizitrack.git
cd gizitrack
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Buat File `.env`

```bash
cp .env.example .env
```

Lalu buka file `.env` yang baru dibuat, sesuaikan bagian ini:

```env
DB_DATABASE=gizitrack
DB_USERNAME=root
DB_PASSWORD=isi_password_mysql_kamu
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buka MySQL/phpMyAdmin, buat database baru bernama `gizitrack`.

### 6. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat semua tabel dan mengisi akun testing awal.

### 7. Install Dependency Frontend

```bash
npm install
```

### 8. Jalankan Aplikasi

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

app/Http/Controllers/
├── Admin/       → Fitur khusus Admin 
├── Vendor/      → Fitur khusus Vendor 
└── Sekolah/     → Fitur khusus Sekolah 

resources/views/
├── admin/       → Halaman Blade untuk Admin
├── vendor/      → Halaman Blade untuk Vendor
└── sekolah/     → Halaman Blade untuk Sekolah

routes/
└── web.php      → Semua route (sudah dikelompokkan per role)

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
Route::resource('menus', MenuController::class);
```

**3. Buat Migration** (jika butuh tabel baru):
```bash
php artisan make:migration create_menus_table
```

**4. Buat Model**:
```bash
php artisan make:model Menu
```

**5. Buat View** di `resources/views/vendor/menus/`

---

## Aturan Git (Wajib Diikuti)

- ❌ Jangan pernah push langsung ke branch `main`
- ✅ Buat branch baru untuk setiap fitur: `feature/nama-fitur`
- ✅ Contoh: `feature/kelola-menu`, `feature/login-system`
- ✅ Setelah selesai, buat Pull Request ke `main`

### Format Pesan Commit
Gunakan format: `jenis: deskripsi singkat`
- `feat`: untuk fitur baru (contoh: `feat: tambah crud menu vendor`)
- `fix`: untuk perbaikan bug
- `docs`: perubahan dokumentasi (README)
- `style`: perubahan tampilan (CSS/Layout) tanpa mengubah logika

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
→ Pastikan `npm run dev` sedang berjalan di terminal lain