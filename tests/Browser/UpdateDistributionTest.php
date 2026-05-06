<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateDistributionTest extends DuskTestCase
{
    public function testUpdateDistributionSuccess()
    {
        Distribusi::query()->delete();

        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $distribusi = Distribusi::create([
            'sekolah_tujuan' => 'SD Update Positif',
            'jumlah_porsi' => 50,
            'tanggal_pengiriman' => '2026-05-10',
            'status' => 'Pending'
        ]);

        $this->browse(function (Browser $browser) use ($user, $distribusi) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->clickLink('Edit')
                ->waitForText('Edit Distribusi')
                
                // Ubah data
                ->type('jumlah_porsi', '150')
                ->select('status', 'Di Perjalanan')
                ->press('Update')
                
                // Suruh robot nunggu redirect selesai (1 detik)
                ->pause(1000) 
                
                // Cek hasil
                ->assertPathIs('/vendor/distribusi')
                ->assertSee('Data berhasil diupdate')
                ->assertSee('150')
                ->assertSee('Di Perjalanan');
        });
    }
}