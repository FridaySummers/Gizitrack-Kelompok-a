<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VendorMenuTest extends DuskTestCase
{
    /**
     * Skenario PBI-11: Vendor berhasil menambahkan menu baru.
     */
    public function test_vendor_bisa_tambah_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login') 
                ->type('email', 'khadafiadisaputra.10@gmail.com') 
                ->type('password', 'dapi1234') 
                ->press('LOG IN') 
                ->pause(2000) 
                ->screenshot('1-BUKTI-HABIS-LOGIN') // 📸 CCTV 1: Liat apa loginnya berhasil
                ->visit('/vendor/menu/create') 
                ->screenshot('2-BUKTI-HALAMAN-FORM') // 📸 CCTV 2: Liat apa form-nya kebuka atau 404
                ->waitFor('input[name="name"]', 5) 
                ->type('name', 'Nasi Goreng Spesial') 
                ->type('description', 'Nasi goreng dengan telur dan ayam') 
                ->type('calories', '500') 
                ->type('price', '25000') 
                ->press('Simpan') 
                ->assertPathIs('/vendor/menu') 
                ->screenshot('PBI-11-Tambah-Menu-Berhasil');
        });
    }
}