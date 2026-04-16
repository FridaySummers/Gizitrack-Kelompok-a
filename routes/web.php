<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Sekolah\DashboardController as SekolahDashboard;

// ── Public ──────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── Auth routes (login, logout — dari Breeze) ───────────
require __DIR__.'/auth.php';

// ── Admin ────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Tambahin route admin disini
    // contoh: Route::resource('accounts', AccountController::class);
});

// ── Vendor ───────────────────────────────────────────────
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');

    // contoh: Route::resource('menus', MenuController::class);
});

// ── Sekolah ──────────────────────────────────────────────
Route::middleware(['auth', 'role:sekolah'])->prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('/dashboard', [SekolahDashboard::class, 'index'])->name('dashboard');

    // contoh: Route::resource('distributions', DistributionController::class);
});