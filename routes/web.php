<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Sekolah\DashboardController as SekolahDashboard;
use App\Http\Controllers\Sekolah\FeedbackController;
use App\Http\Controllers\DistribusiController;

// ── 1. PUBLIC ROUTES ──────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── 2. POLISI LALU LINTAS (FIX ERROR DASHBOARD) ───────────────────
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role == 'admin')   return redirect()->route('admin.dashboard');
    if ($role == 'vendor')  return redirect()->route('vendor.dashboard');
    if ($role == 'sekolah') return redirect()->route('sekolah.dashboard');

    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ── 3. PROFILE ROUTES (FIX ERROR PROFILE.EDIT) ────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── 4. GRUP ADMIN ────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
});

// ── 5. GRUP VENDOR (KAMAR KIRANA) ────────────────────────────────
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');

    // Fitur Kelola Distribusi (PBI-15 sampai PBI-18)
    Route::resource('distribusi', DistribusiController::class);
    Route::resource('menu', \App\Http\Controllers\Vendor\MenuController::class);
    // contoh: Route::resource('menus', MenuController::class);
});

// ── 6. GRUP SEKOLAH ──────────────────────────────────────────────
Route::middleware(['auth', 'role:sekolah'])->prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('/dashboard', [SekolahDashboard::class, 'index'])->name('dashboard');
    
    // Fitur Feedback (PBI-19)
    Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
});

// ── 7. AUTH ROUTES ───────────────────────────────────────────────
require __DIR__.'/auth.php';