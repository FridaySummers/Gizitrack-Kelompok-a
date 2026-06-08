<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DistributionController as AdminDistributionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\MenuController;
use App\Http\Controllers\Sekolah\DashboardController as SekolahDashboard;
use App\Http\Controllers\Sekolah\FeedbackController;
use App\Http\Controllers\Sekolah\DistributionController as SekolahDistributionController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;

// ── 1. PUBLIC ROUTES ──────────────────────────────────────────────
<<<<<<< HEAD
Route::get('/', fn() => view('welcome'));

// ── 2. DASHBOARD ─────────────────────────────────────────────────–
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ── 4. GRUP ADMIN ────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Fitur Lihat Status Distribusi (PBI-20)
    Route::get('/distributions', [AdminDistributionController::class, 'index'])->name('distributions.index');
=======
Route::get("/", fn() => redirect()->route("login"));

// ── 2. POLISI LALU LINTAS (FIX ERROR DASHBOARD) ───────────────────
Route::get("/dashboard", function () {
    $role = auth()->user()->role->value;

    if ($role === "super_admin" || $role === "admin") {
        return redirect()->route("admin.dashboard");
    }
    if ($role === "vendor") {
        return redirect()->route("vendor.dashboard");
    }
    if ($role === "sekolah") {
        return redirect()->route("sekolah.dashboard");
    }

    return redirect("/");
})
    ->middleware(["auth"])
    ->name("dashboard");

// ── 3. PROFILE ROUTES (FIX ERROR PROFILE.EDIT) ────────────────────
Route::middleware(["auth", "role:vendor,sekolah"])->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
});

// ── 4. GRUP SUPER ADMIN — hanya kelola akun ──────────────────────
Route::middleware(["auth", "role:super_admin"])
    ->prefix("super-admin")
    ->name("super_admin.")
    ->group(function () {
        // Fitur Kelola Semua Akun (PBI)
        Route::resource("users", SuperAdminUserController::class)->except(["show"]);
    });

// ── 5. GRUP ADMIN SHARED (admin + super_admin) ───────────────────
// Dashboard, Distributions, Analytics, Reports — IDENTIK untuk keduanya.
Route::middleware(["auth", "role:admin,super_admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
<<<<<<< HEAD
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name(
            "dashboard",
        );
>>>>>>> 53f90b7ef7e2319fd437e8008fe77906570129ee
=======
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name("dashboard");
>>>>>>> 348de09e59b7393570f59668cda802669af2497a

        // Fitur Lihat Status Distribusi (PBI-20)
        Route::get("/distributions", [
            AdminDistributionController::class,
            "index",
        ])->name("distributions.index");

        // API untuk Live Tracking (PBI-25)
        Route::get("/api/distribusi", [
            DistribusiController::class,
            "apiIndex",
        ])->name("api.distribusi");

<<<<<<< HEAD
// ── 5. GRUP VENDOR (KAMAR KIRANA) ────────────────────────────────
Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');
=======
        // API Analytics (PBI-23, PBI-24)
        Route::get("/api/analytics/summary", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "summary",
        ])->name("api.analytics.summary");
        Route::get("/api/analytics/chart", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "chartData",
        ])->name("api.analytics.chart");
>>>>>>> 53f90b7ef7e2319fd437e8008fe77906570129ee

        // Export Reports (PBI-26)
        Route::get("/reports/export", [
            \App\Http\Controllers\Admin\ReportsController::class,
            "export",
        ])->name("reports.export");
    });

// ── 6. GRUP ADMIN ONLY — User Management ─────────────────────────
// Kelola Akun Vendor & Sekolah — hanya bisa diakses admin biasa.
Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::resource("users", AdminUserController::class)->except(["show"]);
    });

// ── 7. GRUP VENDOR ───────────────────────────────────────────────
Route::middleware(["auth", "role:vendor"])
    ->prefix("vendor")
    ->name("vendor.")
    ->group(function () {
        Route::get("/dashboard", [VendorDashboard::class, "index"])->name(
            "dashboard",
        );

        // Fitur Kelola Distribusi (PBI-15 sampai PBI-18)
        // PBI-34: Riwayat Pengiriman Harian
        Route::get("distribusi/riwayat", [
            DistribusiController::class,
            "riwayat",
        ])->name("distribusi.riwayat");
        Route::resource("distribusi", DistribusiController::class);

        // PBI-11 sampai PBI-14: Kelola Menu (Create, Read, Update, Delete)
        Route::resource("menu", MenuController::class);
    });

<<<<<<< HEAD
// ── 6. GRUP SEKOLAH ──────────────────────────────────────────────
<<<<<<< HEAD
Route::prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('/dashboard', [SekolahDashboard::class, 'index'])->name('dashboard');
    
    // Fitur Feedback (PBI-19, PBI-22)
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    
    // Fitur Lihat Status & Konfirmasi Distribusi (PBI-20, PBI-21)
    Route::get('/distributions', [SekolahDistributionController::class, 'index'])->name('distributions.index');
    Route::patch('/distributions/{distribution}', [SekolahDistributionController::class, 'update'])->name('distributions.update');
});

// ── 7. AUTH ROUTES (DISABLED) ────────────────────────────────────
Route::get('login', fn () => redirect()->route('dashboard'))->name('login');
Route::post('login', fn () => redirect()->route('dashboard'));
Route::get('register', fn () => redirect()->route('dashboard'))->name('register');
Route::post('register', fn () => redirect()->route('dashboard'));
Route::get('forgot-password', fn () => redirect()->route('dashboard'))->name('password.request');
Route::post('forgot-password', fn () => redirect()->route('dashboard'))->name('password.email');
Route::get('reset-password/{token}', fn () => redirect()->route('dashboard'))->name('password.reset');
Route::post('reset-password', fn () => redirect()->route('dashboard'))->name('password.store');
Route::get('verify-email', fn () => redirect()->route('dashboard'))->name('verification.notice');
Route::get('verify-email/{id}/{hash}', fn () => redirect()->route('dashboard'))->name('verification.verify');
Route::post('email/verification-notification', fn () => redirect()->route('dashboard'))->name('verification.send');
Route::get('confirm-password', fn () => redirect()->route('dashboard'))->name('password.confirm');
Route::post('confirm-password', fn () => redirect()->route('dashboard'));
Route::match(['put', 'patch'], 'password', fn () => redirect()->route('dashboard'))->name('password.update');
Route::post('password', fn () => redirect()->route('dashboard'));
Route::post('logout', fn () => redirect()->route('dashboard'))->name('logout');

// Profile routes are disabled because login/password features are removed
Route::get('profile', fn () => redirect()->route('dashboard'))->name('profile.edit');
Route::patch('profile', fn () => redirect()->route('dashboard'))->name('profile.update');
Route::delete('profile', fn () => redirect()->route('dashboard'))->name('profile.destroy');
=======
=======
// ── 8. GRUP SEKOLAH ──────────────────────────────────────────────
>>>>>>> 348de09e59b7393570f59668cda802669af2497a
Route::middleware(["auth", "role:sekolah"])
    ->prefix("sekolah")
    ->name("sekolah.")
    ->group(function () {
        Route::get("/dashboard", [SekolahDashboard::class, "index"])->name(
            "dashboard",
        );

        // Fitur Lihat Status & Konfirmasi Distribusi (PBI-20, PBI-21, PBI-36, PBI-37, PBI-38)
        Route::get("/distributions", [
            SekolahDistributionController::class,
            "index",
        ])->name("distributions.index");
        Route::patch("/distributions/{distribution}", [
            SekolahDistributionController::class,
            "update",
        ])->name("distributions.update");
    });

// ── 9. AUTH ROUTES ───────────────────────────────────────────────
require __DIR__ . "/auth.php";
>>>>>>> 53f90b7ef7e2319fd437e8008fe77906570129ee
