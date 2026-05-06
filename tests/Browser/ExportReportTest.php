<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ExportReportTest extends DuskTestCase
{
    public function testExportReport(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@gizitrack.test')->first();
            $browser->loginAs($admin)
                ->visit('/admin/distributions')
                ->waitForText('TANGGAL') 
                ->assertSee('Export')
                ->clickLink('Export')
                ->pause(2000); 
        });
    }
}
