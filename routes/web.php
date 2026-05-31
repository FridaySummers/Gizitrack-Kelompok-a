<?php

use Illuminate\Support\Facades\Route;
use App\Enums\UserRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DistributionController as AdminDistributionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\MenuController;
use App\Http\Controllers\Sekolah\DashboardController as SekolahDashboard;
use App\Http\Controllers\Sekolah\FeedbackController;
use App\Http\Controllers\Sekolah\DistributionController as SekolahDistributionController;
use App\Http\Controllers\DistribusiController;

// ── 1. PUBLIC ROUTES ──────────────────────────────────────────────
Route::get("/", fn() => redirect()->route("login"));

// ── 2. POLISI LALU LINTAS – PBI#28: redirect via UserRole enum ────
Route::get("/dashboard", function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();

    // Gunakan enum helper dashboardRoute() – type-safe, tanpa magic string
    if ($user->role instanceof UserRole) {
        return redirect()->route($user->role->dashboardRoute());
    }

    return redirect("/");
})
    ->middleware(["auth"])
    ->name("dashboard");

// ── 3. PROFILE ROUTES (FIX ERROR PROFILE.EDIT) ────────────────────
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );
});

// ── 4. GRUP ADMIN ────────────────────────────────────────────────
Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name(
            "dashboard",
        );

        // Fitur Lihat Status Distribusi (PBI-20)
        Route::get("/distributions", [
            AdminDistributionController::class,
            "index",
        ])->name("distributions.index");

        // Fitur Kelola Akun Vendor & Sekolah (PBI-7 sampai PBI-10)
        Route::resource("users", AdminUserController::class)->except(["show"]);

        // API untuk Live Tracking (PBI-25)
        Route::get("/api/distribusi", [
            DistribusiController::class,
            "apiIndex",
        ])->name("api.distribusi");

        // API Analytics (PBI-23, PBI-24)
        Route::get("/api/analytics/summary", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "summary",
        ])->name("api.analytics.summary");
        Route::get("/api/analytics/chart", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "chartData",
        ])->name("api.analytics.chart");

        // Export Reports (PBI-26)
        Route::get("/reports/export", [
            \App\Http\Controllers\Admin\ReportsController::class,
            "export",
        ])->name("reports.export");
    });

// ── 5. GRUP VENDOR ───────────────────────────────────────────────
Route::middleware(["auth", "role:vendor"])
    ->prefix("vendor")
    ->name("vendor.")
    ->group(function () {
        Route::get("/dashboard", [VendorDashboard::class, "index"])->name(
            "dashboard",
        );

        // Fitur Kelola Distribusi (PBI-15 sampai PBI-18)
        // PBI-34: Riwayat Pengiriman Harian
        Route::get('distribusi/riwayat', [DistribusiController::class, 'riwayat'])
            ->name('distribusi.riwayat');
        Route::resource("distribusi", DistribusiController::class);

        // PBI-11 sampai PBI-14: Kelola Menu (Create, Read, Update, Delete)
        Route::resource("menu", MenuController::class);
    });

// ── 6. GRUP SEKOLAH ──────────────────────────────────────────────
Route::middleware(["auth", "role:sekolah"])
    ->prefix("sekolah")
    ->name("sekolah.")
    ->group(function () {
        Route::get("/dashboard", [SekolahDashboard::class, "index"])->name(
            "dashboard",
        );

        // Fitur Feedback (PBI-19, PBI-22)
        Route::get("/feedbacks", [FeedbackController::class, "index"])->name(
            "feedbacks.index",
        );
        Route::get("/feedbacks/create", [
            FeedbackController::class,
            "create",
        ])->name("feedbacks.create");
        Route::post("/feedbacks", [FeedbackController::class, "store"])->name(
            "feedbacks.store",
        );
        Route::delete("/feedbacks/{feedback}", [
            FeedbackController::class,
            "destroy",
        ])->name("feedbacks.destroy");

        // Fitur Lihat Status & Konfirmasi Distribusi (PBI-20, PBI-21)
        Route::get("/distributions", [
            SekolahDistributionController::class,
            "index",
        ])->name("distributions.index");
        Route::patch("/distributions/{distribution}", [
            SekolahDistributionController::class,
            "update",
        ])->name("distributions.update");
    });

// ── 7. AUTH ROUTES ───────────────────────────────────────────────
require __DIR__ . "/auth.php";
