<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SummaryDashboardTest extends DuskTestCase
{
    public function testSummaryDashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit("/login")
                ->assertSee("Email")
                ->type("email", "admin@gizitrack.test")
                ->type("password", "password")
                ->click('button[type="submit"]')
                ->waitForLocation("/admin/dashboard")
                ->assertSee("HALO ADMIN! 🛡️")
                ->assertPathIs("/admin/dashboard")
                ->assertSee("Total Distribusi")
                ->assertSee("Total Vendor")
                ->assertSee("Total Sekolah");
        });
    }
}
