#!/bin/bash

# ==============================================================================
# GiziTrack Production Optimization Script
# ==============================================================================
# Script ini digunakan untuk menyiapkan aplikasi dalam kondisi performa terbaik
# untuk lingkungan production atau final testing.
# ==============================================================================

echo "🚀 Memulai proses optimasi GiziTrack..."

# 1. Optimasi Composer Autoloader
echo "📦 Mengoptimalkan autoloader Composer..."
composer install --optimize-autoloader --no-dev

# 2. Membersihkan dan Me-cache Konfigurasi
echo "⚙️  Caching konfigurasi..."
php artisan config:cache

# 3. Me-cache Sistem Routing
echo "🗺️  Caching routes..."
php artisan route:cache

# 4. Me-cache Tampilan Blade
echo "🎨 Caching views..."
php artisan view:cache

# 5. Membangun Aset Frontend Terkompresi (Vite)
echo "🌐 Membangun aset frontend (Production Build)..."
npm run build

# 6. Membersihkan Cache Aplikasi Lainnya
echo "🧹 Membersihkan cache sisa..."
php artisan cache:clear

echo "✅ Optimasi selesai! Aplikasi siap digunakan."
