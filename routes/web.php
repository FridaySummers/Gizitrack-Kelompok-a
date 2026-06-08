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
use App\Http\Controllers\ProfileController;

// ── 1. PUBLIC ROUTES ──────────────────────────────────────────────
Route::get("/", fn() => redirect()->route("login"));

// ── 2. DASHBOARD (REDIRECT BERDASARKAN ROLE) ───────────────────────
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

// ── 3. PROFILE ROUTES ─────────────────────────────────────────────
Route::middleware(["auth", "role:vendor,sekolah"])->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
});

// ── 4. GRUP SUPER ADMIN ───────────────────────────────────────────
Route::middleware(["auth", "role:super_admin"])
    ->prefix("super-admin")
    ->name("super_admin.")
    ->group(function () {
        Route::resource("users", SuperAdminUserController::class)->except(["show"]);
    });

// ── 5. GRUP ADMIN SHARED (admin + super_admin) ───────────────────
Route::middleware(["auth", "role:admin,super_admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name("dashboard");

        Route::get("/distributions", [
            AdminDistributionController::class,
            "index",
        ])->name("distributions.index");

        Route::get("/api/distribusi", [
            DistribusiController::class,
            "apiIndex",
        ])->name("api.distribusi");

        Route::get("/api/analytics/summary", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "summary",
        ])->name("api.analytics.summary");
        
        Route::get("/api/analytics/chart", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "chartData",
        ])->name("api.analytics.chart");

        Route::get("/reports/export", [
            \App\Http\Controllers\Admin\ReportsController::class,
            "export",
        ])->name("reports.export");
    });

// ── 6. GRUP ADMIN ONLY ───────────────────────────────────────────
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
        Route::get("/dashboard", [VendorDashboard::class, "index"])->name("dashboard");

        Route::get("distribusi/riwayat", [
            DistribusiController::class,
            "riwayat",
        ])->name("distribusi.riwayat");
        Route::resource("distribusi", DistribusiController::class);

        Route::resource("menu", MenuController::class);
    });

// ── 8. GRUP SEKOLAH ──────────────────────────────────────────────
Route::middleware(["auth", "role:sekolah"])
    ->prefix("sekolah")
    ->name("sekolah.")
    ->group(function () {
        Route::get("/dashboard", [SekolahDashboard::class, "index"])->name("dashboard");

        Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
        Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
        Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');

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
