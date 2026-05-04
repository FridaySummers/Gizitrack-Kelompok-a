<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Distribusi;

class LiveTrackingTest extends DuskTestCase
{
    public function testLiveTracking(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@gizitrack.test')->first();
            $browser->loginAs($admin)
                ->visit('/admin/distributions')
                ->waitForText('TANGGAL')
                ->assertSee('SEKOLAH')
                ->assertSee('PORSI')
                ->assertSee('STATUS')
                ->assertSee('FEEDBACK');
            $distribusi = Distribusi::first();
            if ($distribusi) {
                $browser->assertSee($distribusi->sekolah_tujuan);
            } else {
                $browser->assertSee('Belum ada data');
            }
        });
    }
}
