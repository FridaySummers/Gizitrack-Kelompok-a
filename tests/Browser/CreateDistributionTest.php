<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateDistributionTest extends DuskTestCase
{
    /**
     * Test vendor berhasil menambah data distribusi
     */
    public function testCreateDistribution()
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
                ->assertSee('Distribusi')

                // buka form tambah distribusi
                ->clickLink('Input Pengiriman Baru')
                ->waitForText('Tambah Distribusi')

                // isi form
                ->type('sekolah_tujuan', 'SMAN 2 Cikarang Utara')
                ->type('jumlah_porsi', '1000');

            // isi tanggal
            $browser->script("
                document.querySelector('input[name=tanggal_pengiriman]').value='2024-07-01'
            ");

            // submit
            $browser->press('Simpan');

            // validasi berhasil kembali ke halaman distribusi
            $browser->pause(2000)
                ->assertPathIs('/vendor/distribusi')
                ->assertSee('Distribusi');
        });
    }
}
