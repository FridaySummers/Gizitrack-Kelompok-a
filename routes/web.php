<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;

// ── 1. PUBLIC ROUTES ──────────────────────────────────────────────
Route::get("/", fn() => redirect()->route("login"));

// ── 2. DASHBOARD REDIRECT ─────────────────────────────────────────
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
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])
        ->middleware("password.confirm")
        ->name("profile.update");
});

// ── 4. SUPER ADMIN ────────────────────────────────────────────────
Route::middleware(["auth", "role:super_admin"])
    ->prefix("super-admin")
    ->name("super_admin.")
    ->group(function () {
        Route::resource("users", SuperAdminUserController::class)
            ->except(["show", "create", "store"]);
            
        Route::get("users/create", [SuperAdminUserController::class, "create"])
            ->name("users.create")
            ->middleware("password.confirm");
            
        Route::post("users", [SuperAdminUserController::class, "store"])
            ->name("users.store")
            ->middleware("password.confirm");


        // Impersonation: Take session
        Route::get("impersonate/{user}", [
            \App\Http\Controllers\SuperAdmin\ImpersonateController::class,
            "take",
        ])->name("impersonate.take");
    });

// ── 5. IMPERSONATION LEAVE (GLOBAL) ───────────────────────────────
Route::middleware(["auth"])
    ->get("impersonate/leave", [
        \App\Http\Controllers\SuperAdmin\ImpersonateController::class,
        "leave",
    ])
    ->name("impersonate.leave");

// ── 6. ADMIN SHARED: admin + super_admin ──────────────────────────
Route::middleware(["auth", "role:admin,super_admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name(
            "dashboard",
        );

        // PBI-40: Read Seluruh Logistik / Audit Trail
        Route::get("/distributions", [
            AdminDistributionController::class,
            "index",
        ])->name("distributions.index");

        // PBI-41: Intervensi Darurat - Revisi Distribusi oleh Admin
        Route::patch("/distributions/{distribution}/revise", [
            AdminDistributionController::class,
            "revise",
        ])->name("distributions.revise");

        // PBI-41: Intervensi Darurat - Pembatalan Distribusi oleh Admin
        Route::patch("/distributions/{distribution}/cancel", [
            AdminDistributionController::class,
            "cancel",
        ])->name("distributions.cancel");

        // API untuk Live Tracking
        Route::get("/api/distribusi", [
            DistribusiController::class,
            "apiIndex",
        ])->name("api.distribusi");

        // API Analytics
        Route::get("/api/analytics/summary", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "summary",
        ])->name("api.analytics.summary");

        Route::get("/api/analytics/chart", [
            \App\Http\Controllers\Admin\AnalyticsController::class,
            "chartData",
        ])->name("api.analytics.chart");

        // Export Reports
        Route::get("/reports/export", [
            \App\Http\Controllers\Admin\ReportsController::class,
            "export",
        ])->name("reports.export");

        Route::get("/reports/export-excel", [
            \App\Http\Controllers\Admin\ReportsController::class,
            "exportExcel",
        ])->name("reports.export_excel");
    });

// ── 6. ADMIN ONLY: User Management ────────────────────────────────
Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::resource("users", AdminUserController::class)
            ->except(["show", "create", "store"]);
            
        Route::get("users/create", [AdminUserController::class, "create"])
            ->name("users.create")
            ->middleware("password.confirm");
            
        Route::post("users", [AdminUserController::class, "store"])
            ->name("users.store")
            ->middleware("password.confirm");
    });

// ── 7. VENDOR ─────────────────────────────────────────────────────
Route::middleware(["auth", "role:vendor"])
    ->prefix("vendor")
    ->name("vendor.")
    ->group(function () {
        Route::get("/dashboard", [VendorDashboard::class, "index"])->name(
            "dashboard",
        );

        Route::get("distribusi/riwayat", [
            DistribusiController::class,
            "riwayat",
        ])->name("distribusi.riwayat");

        Route::resource("distribusi", DistribusiController::class);

        Route::resource("menu", MenuController::class);
    });

// ── 8. SEKOLAH ────────────────────────────────────────────────────
Route::middleware(["auth", "role:sekolah"])
    ->prefix("sekolah")
    ->name("sekolah.")
    ->group(function () {
        Route::get("/dashboard", [SekolahDashboard::class, "index"])->name(
            "dashboard",
        );

        Route::get("/distributions", [
            SekolahDistributionController::class,
            "index",
        ])->name("distributions.index");

        Route::patch("/distributions/{distribution}", [
            SekolahDistributionController::class,
            "update",
        ])->name("distributions.update");
    });

// ── 9. AUTH ROUTES ────────────────────────────────────────────────
require __DIR__ . "/auth.php";
