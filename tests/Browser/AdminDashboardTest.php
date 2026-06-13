<?php

namespace Tests\Browser;

use App\Models\User;
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

        User::firstOrCreate(
            ["email" => "admin@gizitrack.test"],
            [
                "name" => "Admin",
                "password" => Hash::make("password"),
                "role" => "admin",
            ],
        );
    }

    public function testUISummaryDashboard1(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->waitForText("Halo Admin! 🛡️", 5)
                ->assertSee("TOTAL DISTRIBUSI")
                ->assertSee("TOTAL PORSI")
                ->assertSee("TINGKAT KEBERHASILAN")
                ->assertSee("TOTAL SEKOLAH")
                ->assertSee("STATUS DISTRIBUSI")
                ->assertSee("TREN DISTRIBUSI")
                ->screenshot("PBI23_UISummaryDashboard");
        });
    }

    public function testAPIAnalytics1(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->pause(2000)
                ->assertPresent("#total-distribusi")
                ->assertPresent("#total-porsi")
                ->assertPresent("#success-rate")
                ->assertPresent("#statusChart")
                ->assertPresent("#dailyChart")
                ->assertPresent("#topSchoolsChart")
                ->assertPresent("#topIssuesChart")
                ->screenshot("PBI24_APIAnalytics");
        });
    }

    public function testLiveTrackingTable1(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->waitForText("LIVE TRACKING PENGIRIMAN", 5)
                ->assertSee("ID")
                ->assertSee("SEKOLAH TUJUAN")
                ->assertSee("JUMLAH PORSI")
                ->assertSee("TANGGAL")
                ->assertSee("STATUS")
                ->assertSee("LAT")
                ->assertSee("LNG")
                ->assertSee("AKSI")
                ->pause(2000)
                ->screenshot("PBI25_LiveTrackingTable");
        });
    }

    public function testExportReport1(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->waitForText("UNDUH LAPORAN DISTRIBUSI", 5)
                ->assertVisible('input[name="start_date"]')
                ->assertVisible('input[name="end_date"]')
                ->assertSee("UNDUH PDF")
                ->type("start_date", now()->startOfMonth()->format("Y-m-d"))
                ->type("end_date", now()->format("Y-m-d"))
                ->press("UNDUH PDF")
                ->pause(2000)
                ->screenshot("PBI26_ExportReport");
        });
    }

    public function testUISummaryDashboard2(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->logout()
                ->visit("/admin/dashboard")
                ->assertPathIsNot("/admin/dashboard")
                ->screenshot("PBI23_Negative_Unauthenticated");
        });
    }

    public function testAPIAnalytics2(): void
    {
        $user = User::firstOrCreate(
            ["email" => "user@gizitrack.test"],
            [
                "name" => "Regular User",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit("/admin/dashboard")
                ->assertMissing("#statusChart")
                ->assertMissing("#dailyChart")
                ->screenshot("PBI24_Negative_APIAnalytics");
        });
    }

    public function testLiveTrackingTable2(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->logout()
                ->visit("/admin/dashboard")
                ->assertDontSee("Live Tracking Pengiriman")
                ->screenshot("PBI25_Negative_LiveTrackingTable");
        });
    }

    public function testExportReport2(): void
    {
        $admin = User::where("email", "admin@gizitrack.test")->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit("/admin/dashboard")
                ->assertPathIs("/admin/dashboard")
                ->waitForText("UNDUH LAPORAN DISTRIBUSI", 5)
                ->type("start_date", now()->format("Y-m-d"))
                ->type("end_date", now()->subDays(5)->format("Y-m-d"))
                ->press("UNDUH PDF")
                ->pause(2000)
                ->screenshot("PBI26_Negative_ExportReportInvalidDates");
        });
    }
}
