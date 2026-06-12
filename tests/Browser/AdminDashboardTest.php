<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use App\Models\Menu;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminDashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat akun admin sesuai UserSeeder
        User::firstOrCreate(
            ["email" => "admin@gizitrack.test"],
            [
                "name" => "Admin GiziTrack",
                "password" => Hash::make("password"),
                "role" => "admin",
            ],
        );

        // Buat akun vendor sesuai UserSeeder
        $vendor = User::firstOrCreate(
            ["email" => "vendor@gizitrack.test"],
            [
                "name" => "Dapur Nusantara",
                "password" => Hash::make("password"),
                "role" => "vendor",
            ],
        );

        // Buat akun sekolah sesuai UserSeeder
        $sekolah = User::firstOrCreate(
            ["email" => "sekolah@gizitrack.test"],
            [
                "name" => "SDN 01 Pagi",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );

        // Buat menu untuk relasi distribusi
        $menu = Menu::firstOrCreate(
            ["name" => "Nasi Ayam Geprek"],
            [
                "vendor_id" => $vendor->id,
                "description" => "Menu test",
                "calories" => 500,
                "price" => 15000,
            ],
        );

        // Buat data distribusi sesuai DistribusiSeeder
        Distribusi::create([
            "sekolah_id" => $sekolah->id,
            "vendor_id" => $vendor->id,
            "menu_id" => $menu->id,
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 450,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Dikirim",
            "latitude" => -6.175392,
            "longitude" => 106.827153,
            "last_updated" => now(),
        ]);

        Distribusi::create([
            "sekolah_id" => $sekolah->id,
            "vendor_id" => $vendor->id,
            "menu_id" => $menu->id,
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 200,
            "tanggal_pengiriman" => now()->subDays(1),
            "status" => "Diterima",
        ]);
    }

    /**
     * PBI-23 Positive: Admin melihat ringkasan dashboard dengan widget statistik.
     * Elemen real: h2 "Halo Admin!", p "Total Distribusi", p "Total Porsi",
     *              p "Tingkat Keberhasilan", p "Total Sekolah",
     *              #total-distribusi, #total-porsi, #success-rate, #total-sekolah
     */
    public function test_admin_dapat_melihat_ringkasan_dashboard(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                // Header title dari @section('title', 'Dashboard Admin')
                ->assertSee("Dashboard Admin")
                // Sambutan dari h2 di line 9 dashboard.blade.php
                ->waitForText("Halo", 5)
                // Sidebar branding dari layouts/sidebar.blade.php line 39
                ->assertSee("GiziTrack")
                // Stats card labels dari dashboard.blade.php line 29, 41, 53, 65
                ->assertSee("Total Distribusi")
                ->assertSee("Total Porsi")
                ->assertSee("Tingkat Keberhasilan")
                ->assertSee("Total Sekolah")
                // Stats card IDs dari dashboard.blade.php line 30, 42, 54, 66
                ->assertPresent("#total-distribusi")
                ->assertPresent("#total-porsi")
                ->assertPresent("#success-rate")
                ->assertPresent("#total-sekolah")
                // Badge labels dari dashboard.blade.php line 27, 39, 51, 63
                ->assertSee("Logistik")
                ->assertSee("Partner")
                ->assertSee("Kualitas")
                ->assertSee("Instansi")
                // Status badge dari dashboard.blade.php line 14
                ->assertSee("Sistem Terpusat Aktif")
                ->screenshot("PBI23_UISummaryDashboard");
        });
    }

    /**
     * PBI-24 Positive: Admin melihat grafik analitik yang dimuat dari API.
     * Elemen real: canvas#statusChart, canvas#dailyChart, canvas#topSchoolsChart,
     *              canvas#topIssuesChart, h3 "Status Distribusi", h3 "Tren Distribusi"
     */
    public function test_admin_dapat_melihat_grafik_analitik(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->pause(2000)
                // Chart section titles dari dashboard.blade.php line 143, 155, 167, 179
                ->assertSee("Status Distribusi")
                ->assertSee("Tren Distribusi (7 Hari Terakhir)")
                ->assertSee("Top 5 Sekolah (Porsi Terbanyak)")
                ->assertSee("Top 5 Sekolah (Kendala Terbanyak)")
                // Canvas elements dari dashboard.blade.php line 146, 158, 170, 182
                ->assertPresent("canvas#statusChart")
                ->assertPresent("canvas#dailyChart")
                ->assertPresent("canvas#topSchoolsChart")
                ->assertPresent("canvas#topIssuesChart")
                // Stats element IDs dari dashboard.blade.php line 30, 42, 54
                ->assertPresent("#total-distribusi")
                ->assertPresent("#total-porsi")
                ->assertPresent("#success-rate")
                ->screenshot("PBI24_APIAnalytics");
        });
    }

    /**
     * PBI-25 Positive: Admin melihat tabel live tracking pengiriman.
     * Elemen real: table#tracking-table, tbody#tracking-body,
     *              th headers "ID", "Sekolah Tujuan", "Jumlah Porsi", etc.
     *              h3 "Live Tracking Pengiriman", a "Kelola Distribusi →"
     */
    public function test_admin_dapat_melihat_tabel_live_tracking(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                // Section title dari dashboard.blade.php line 195
                ->waitForText("Live Tracking Pengiriman", 5)
                // Link "Kelola Distribusi →" dari dashboard.blade.php line 197
                ->assertSee("Kelola Distribusi")
                // Table element dari dashboard.blade.php line 200
                ->assertPresent("table#tracking-table")
                // Tbody element dari dashboard.blade.php line 213
                ->assertPresent("tbody#tracking-body")
                // Table headers dari dashboard.blade.php line 203-210
                ->assertSeeIn("thead", "ID")
                ->assertSeeIn("thead", "Sekolah Tujuan")
                ->assertSeeIn("thead", "Jumlah Porsi")
                ->assertSeeIn("thead", "Tanggal")
                ->assertSeeIn("thead", "Status")
                ->assertSeeIn("thead", "Lat")
                ->assertSeeIn("thead", "Lng")
                ->assertSeeIn("thead", "Aksi")
                ->pause(3000)
                // Setelah JS fetch, data distribusi harus muncul (nama sekolah dari seed)
                ->assertSeeIn("#tracking-body", "SDN 01 Pagi")
                ->screenshot("PBI25_LiveTrackingTable");
        });
    }

    /**
     * PBI-26 Positive: Admin mengunduh laporan distribusi PDF.
     * Elemen real: h3 "Unduh Laporan Distribusi", input#start_date, input#end_date,
     *              button "Unduh PDF", button "Export Excel"
     */
    public function test_admin_dapat_ekspor_laporan_dengan_tanggal_valid(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                // Section title dari dashboard.blade.php line 108
                ->waitForText("Unduh Laporan Distribusi", 5)
                // Subtitle dari dashboard.blade.php line 109
                ->assertSee("Pilih periode tanggal untuk mengunduh laporan dalam format PDF.")
                // Labels dari dashboard.blade.php line 113, 117
                ->assertSee("Mulai")
                ->assertSee("Selesai")
                // Date inputs dari dashboard.blade.php line 114, 118
                ->assertVisible("input#start_date")
                ->assertVisible("input#end_date")
                // Buttons dari dashboard.blade.php line 120-124, 126-131
                ->assertSee("Unduh PDF")
                ->assertSee("Export Excel")
                // Fill form & submit
                ->value("#start_date", now()->startOfMonth()->format("Y-m-d"))
                ->value("#end_date", now()->format("Y-m-d"))
                ->press("Unduh PDF")
                ->pause(2000)
                ->screenshot("PBI26_ExportReport");
        });
    }

    /**
     * PBI-23 Negative: Pengguna belum login tidak bisa akses dashboard admin.
     * Middleware 'auth' di routes/web.php line 75 melakukan redirect ke /login.
     */
    public function test_pengguna_belum_login_tidak_bisa_akses_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->logout()
                ->visit("/admin/dashboard")
                // Middleware auth redirect ke login
                ->assertPathIsNot("/admin/dashboard")
                ->assertPathIs("/login")
                // Halaman login harus tampil, bukan dashboard
                ->assertDontSee("Live Tracking Pengiriman")
                ->assertDontSee("Total Distribusi")
                ->screenshot("PBI23_Negative_Unauthenticated");
        });
    }

    /**
     * PBI-24 Negative: User role sekolah tidak bisa akses halaman admin.
     * Middleware 'role:admin,super_admin' di routes/web.php line 75.
     */
    public function test_non_admin_tidak_dapat_melihat_grafik(): void
    {
        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit("/admin/dashboard")
                // Middleware role memblokir - tidak di halaman admin
                ->assertDontSee("Status Distribusi")
                ->assertMissing("canvas#statusChart")
                ->assertMissing("canvas#dailyChart")
                ->assertMissing("canvas#topSchoolsChart")
                ->assertMissing("canvas#topIssuesChart")
                ->screenshot("PBI24_Negative_APIAnalytics");
        });
    }

    /**
     * PBI-25 Negative: Pengguna belum login tidak melihat tabel live tracking.
     * Middleware 'auth' redirect ke /login.
     */
    public function test_pengguna_belum_login_tidak_melihat_live_tracking(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->logout()
                ->visit("/admin/dashboard")
                // Redirect ke login, tabel tidak tampil
                ->assertDontSee("Live Tracking Pengiriman")
                ->assertMissing("table#tracking-table")
                ->assertMissing("tbody#tracking-body")
                ->screenshot("PBI25_Negative_LiveTrackingTable");
        });
    }

    /**
     * PBI-26 Negative: Admin memasukkan tanggal tidak valid (end < start).
     * Form tetap tampil, submit dengan parameter yang salah.
     */
    public function test_admin_ekspor_laporan_tanggal_tidak_valid(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                // Section dari dashboard.blade.php line 108
                ->waitForText("Unduh Laporan Distribusi", 5)
                // Isi tanggal terbalik: start > end
                ->value("#start_date", now()->format("Y-m-d"))
                ->value("#end_date", now()->subDays(5)->format("Y-m-d"))
                ->press("Unduh PDF")
                ->pause(2000)
                ->screenshot("PBI26_Negative_ExportReportInvalidDates");
        });
    }
}
