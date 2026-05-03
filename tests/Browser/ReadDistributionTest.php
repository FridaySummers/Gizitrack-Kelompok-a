<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReadDistributionTest extends DuskTestCase
{
    public function testReadDistribution()
    {
        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $distribusi = Distribusi::create([
            'sekolah_tujuan' => 'SD Read Positif',
            'jumlah_porsi' => 50,
            'tanggal_pengiriman' => '2026-05-10',
            'status' => 'Pending'
        ]);

        $this->browse(function (Browser $browser) use ($user, $distribusi) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->assertSee('Input Pengiriman Baru')
                ->assertSee($distribusi->sekolah_tujuan)
                ->assertSee($distribusi->jumlah_porsi);
        });
    }
}