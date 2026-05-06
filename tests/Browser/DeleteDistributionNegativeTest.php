<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteDistributionNegativeTest extends DuskTestCase
{
    public function testDeleteDistributionCancel()
    {
        Distribusi::query()->delete();

        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $distribusi = Distribusi::create([
            'sekolah_tujuan' => 'SD Delete Negatif',
            'jumlah_porsi' => 50,
            'tanggal_pengiriman' => '2026-05-10',
            'status' => 'Pending'
        ]);

        $this->browse(function (Browser $browser) use ($user, $distribusi) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->press('Delete')
                ->dismissDialog() // Pencet Cancel di alert
                
                // Pastiin datanya gak jadi kehapus
                ->assertSee($distribusi->sekolah_tujuan);
        });
    }
}