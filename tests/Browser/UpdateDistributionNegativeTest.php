<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateDistributionNegativeTest extends DuskTestCase
{
    public function testUpdateDistributionNegativeValue()
    {
        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $distribusi = Distribusi::create([
            'sekolah_tujuan' => 'SD Update Negatif',
            'jumlah_porsi' => 50,
            'tanggal_pengiriman' => '2026-05-10',
            'status' => 'Pending'
        ]);

        $this->browse(function (Browser $browser) use ($user, $distribusi) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->clickLink('Edit')
                ->waitForText('Edit Distribusi')
                
                // Masukin porsi minus
                ->type('jumlah_porsi', '-10')
                ->press('Update')
                
                // GANTI INI: Suruh robot sabar nunggu halamannya ke-refresh dan teksnya muncul
                ->waitForText('The jumlah porsi field must be at least 1.');
        });
    }
}