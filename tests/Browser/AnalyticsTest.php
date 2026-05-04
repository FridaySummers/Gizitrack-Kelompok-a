<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Distribusi;

class AnalyticsTest extends DuskTestCase
{
    public function testAnalyticsDataIsAccurate(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@gizitrack.test')->first();
            $totalDistribusi = (string) Distribusi::count();
            $totalVendor = (string) User::where('role', 'vendor')->count();
            $totalSekolah = (string) User::where('role', 'sekolah')->count();

            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->waitForText('Total Distribusi')
                ->assertSee($totalDistribusi)
                ->assertSee($totalVendor)
                ->assertSee($totalSekolah);
        });
    }
}
