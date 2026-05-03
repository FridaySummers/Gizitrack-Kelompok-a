<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReadDistributionNegativeTest extends DuskTestCase
{
    /**
     * TC.Dist.006: Menguji tampilan daftar distribusi ketika data kosong (Empty State)
     */
    public function testReadEmptyDistribution()
    {
        // 1. Bikin user vendor baru
        $user = User::create([
            'name' => 'Vendor Test Kosong',
            'email' => 'vendor_kosong' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        // 2. Kosongkan tabel Distribusi biar ngetes empty state-nya valid
        // Hati-hati: Ini bakal ngehapus data dummy dari test sebelumnya
        Distribusi::query()->delete();

        // 3. Mulai testing browser
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/vendor/distribusi')
                
                // Pastiin ada di halaman yang bener
                ->assertPathIs('/vendor/distribusi')
                
                // Pastiin teks dari blok @empty di Blade muncul
                ->assertSee('Belum ada data')
                
                // Pastiin tabelnya dirender dengan benar tanpa error
                ->assertSee('TANGGAL')
                ->assertSee('SEKOLAH')
                ->assertSee('PORSI');
        });
    }
}