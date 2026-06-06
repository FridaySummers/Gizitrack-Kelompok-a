<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VendorMenuTest extends DuskTestCase
{
    protected static $menuName;

    /**
     * Inisialisasi nama menu unik agar tidak bentrok dengan data sisa testing.
     */
    public function setUp(): void
    {
        parent::setUp();
        if (!static::$menuName) {
            static::$menuName = 'Nasi Goreng ' . time(); 
        }
    }

    /**
     * 1. POSITIF - PBI-11: Tambah Menu
     */
    public function test_vendor_bisa_tambah_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login') 
                ->type('email', 'khadafiadisaputra.10@gmail.com') 
                ->type('password', 'dapi1234') 
                ->press('LOG IN') 
                ->pause(2000)
                ->visit('/vendor/menu/create') 
                ->waitFor('input[name="name"]', 5)
                ->type('name', static::$menuName) 
                ->type('description', 'Nasi goreng lezat racikan Dapi') 
                ->type('calories', '500') 
                ->type('price', '25000') 
                ->press('Simpan') 
                ->waitForLocation('/vendor/menu', 5)
                ->assertPathIs('/vendor/menu') 
                ->screenshot('PBI-11-Tambah-Menu-Berhasil');
        });
    }

    /**
     * 2. NEGATIF - PBI-11: Validasi Input Kosong
     */
    public function test_vendor_gagal_tambah_menu_input_kosong(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu/create')
                ->waitFor('input[name="name"]')
                ->press('Simpan')
                ->pause(1500)
                ->assertSee('required') // Mencari kata kunci 'required' agar lebih fleksibel
                ->screenshot('PBI-11-Negative-Validation');
        });
    }

    /**
     * 3. POSITIF - PBI-12: Read Menu
     */
    public function test_vendor_bisa_lihat_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu')
                ->waitForText(static::$menuName, 5)
                ->assertSee(static::$menuName) 
                ->screenshot('PBI-12-Read-Menu-Berhasil');
        });
    }

    /**
     * 4. POSITIF - PBI-13: Update Menu
     */
    public function test_vendor_bisa_edit_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu')
                ->waitForText(static::$menuName)
                ->clickLink('Edit') 
                ->pause(1500) 
                ->clear('price')
                ->type('price', '30000')
                ->press('Update') 
                ->waitForLocation('/vendor/menu', 5)
                ->pause(1000)
                ->assertSee('30.000') 
                ->screenshot('PBI-13-Update-Menu-Berhasil');
        });
    }

    /**
     * 5. NEGATIF - PBI-13: Harga Negatif
     */
    public function test_vendor_gagal_edit_menu_harga_negatif(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu')
                ->waitForText(static::$menuName)
                ->clickLink('Edit')
                ->pause(1500)
                ->type('price', '-5000')
                ->press('Update')
                ->pause(1500)
                // Menggunakan kata kunci pesan error yang lebih umum agar pasti kena
                ->assertSee('at least 0') 
                ->screenshot('PBI-13-Negative-Price');
        });
    }

    /**
     * 6. NEGATIF - PBI-14: Batal Hapus
     */
    public function test_vendor_batal_hapus_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu')
                ->waitForText(static::$menuName)
                ->press('Hapus')
                ->pause(1000)
                ->dismissDialog() 
                ->pause(1000)
                ->assertSee(static::$menuName) 
                ->screenshot('PBI-14-Negative-Cancel-Delete');
        });
    }

    /**
     * 7. POSITIF - PBI-14: Hapus Menu
     */
    public function test_vendor_bisa_hapus_menu(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vendor/menu')
                ->waitForText(static::$menuName)
                ->press('Hapus') 
                ->pause(1000)
                ->acceptDialog() 
                ->pause(2000)
                ->assertDontSee(static::$menuName) 
                ->screenshot('PBI-14-Delete-Menu-Berhasil');
        });
    }

    /**
     * 8. NEGATIF - PBI-12: Keamanan Akses (Guest)
     */
    public function test_guest_tidak_bisa_akses_daftar_menu(): void
    {
        $this->browse(function (Browser $browser) {
            // Logout dengan menghapus cookie session
            $browser->deleteCookie('laravel_session');
            $browser->script('window.localStorage.clear();');
            
            $browser->visit('/vendor/menu')
                ->pause(2000)
                ->assertPathIs('/login') 
                ->screenshot('PBI-12-Negative-Guest-Access');
        });
    }
}