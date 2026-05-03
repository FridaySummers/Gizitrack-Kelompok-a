<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteDistributionTest extends DuskTestCase
{
    public function testDeleteDistributionSuccess()
    {
        $user = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        // 🔥 BERSIHIN DULU SEMUA DATA LAMA BIAR ROBOTNYA GAK SALAH KLIK 🔥
        Distribusi::query()->delete();

        // Bikin nama sekolahnya unik
        $namaSekolahUnik = 'SD Delete ' . uniqid();

        // Bikin dummy data baru (ini bakal jadi satu-satunya data di tabel)
        $distribusi = Distribusi::create([
            'sekolah_tujuan' => $namaSekolahUnik,
            'jumlah_porsi' => 50,
            'tanggal_pengiriman' => '2026-05-10',
            'status' => 'Pending'
        ]);

        $this->browse(function (Browser $browser) use ($user, $distribusi, $namaSekolahUnik) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                ->press('Delete') // Sekarang dia pasti ngeklik data yang bener
                ->acceptDialog() 
                ->pause(1000) // JANGAN LUPA NAPAS SEDETIK
                
                ->assertPathIs('/vendor/distribusi')
                ->assertSee('Data berhasil dihapus')
                ->assertDontSee($namaSekolahUnik);
        });
    }
}