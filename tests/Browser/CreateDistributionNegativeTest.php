<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateDistributionNegativeTest extends DuskTestCase
{
    public function testCreateDistributionNegative()
    {
        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->clickLink('Input Pengiriman Baru')
                ->waitForText('Tambah Distribusi')

                ->press('Simpan')

                ->assertPathIs('/vendor/distribusi/create');
                
        });
    }
}