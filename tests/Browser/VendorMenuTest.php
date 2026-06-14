<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VendorMenuTest extends DuskTestCase
{
    protected static $menuName;
    protected static $vendor;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$menuName) {
            static::$menuName = "Nasi Goreng " . time();
        }

        if (!static::$vendor) {
            static::$vendor = User::firstOrCreate(
                ["email" => "vendor_test@gizitrack.test"],
                [
                    "name" => "Vendor Test",
                    "password" => Hash::make("password"),
                    "role" => "vendor",
                ],
            );
        }
    }

    /**
     * PBI-30: Tambah Menu (Testing Create + TKPI Link Validation)
     */
    public function test_vendor_bisa_tambah_menu_dan_akses_tkpi(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$vendor)
                ->visit("/vendor/menu/create")
                ->waitFor('input[name="name"]', 10)
                // Pakai assertSee biasa agar tidak sensitif terhadap struktur tag HTML-nya
                ->assertSee('Cek TKPI Kemenkes di sini')
                ->type("name", static::$menuName)
                ->type("description", "Nasi goreng lezat racikan Dapi")
                ->type("calories", "500")
                ->type("price", "25000")
                ->press("SIMPAN MENU BARU") // Sesuai screenshot Add Menu
                ->waitForLocation("/vendor/menu", 10)
                ->assertPathIs("/vendor/menu")
                ->screenshot("PBI-30-Tambah-Menu-Berhasil");
        });
    }

    /**
     * PBI-31: Read Daftar Menu (Memastikan scope vendor benar)
     */
    public function test_vendor_hanya_lihat_menu_sendiri(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$vendor)
                ->visit("/vendor/menu")
                ->waitForText(static::$menuName, 10)
                ->assertSee(static::$menuName)
                ->screenshot("PBI-31-Read-Menu-Berhasil");
        });
    }

    /**
     * PBI-32: Update Menu (Testing Update & Policy)
     */
    public function test_vendor_bisa_edit_menu_sendiri(): void
    {
        $this->browse(function (Browser $browser) {
            $menu = Menu::where("name", static::$menuName)->first();
            $browser
                ->loginAs(static::$vendor)
                ->visit("/vendor/menu")
                ->waitForText(static::$menuName, 10)
                ->visit("/vendor/menu/" . $menu->id . "/edit")
                ->waitFor('input[name="calories"]', 10)
                ->clear("calories")
                ->type("calories", "600")
                ->press("KONFIRMASI UPDATE") // Sesuai screenshot Edit Menu
                ->waitForLocation("/vendor/menu", 10)
                ->assertSee("600")
                ->screenshot("PBI-32-Update-Menu-Berhasil");
        });
    }

    /**
     * PBI-32: Keamanan Otorisasi (Vendor tidak bisa edit menu vendor lain)
     */
    public function test_vendor_tidak_bisa_akses_edit_menu_vendor_lain(): void
    {
        // Buat menu milik vendor lain
        $otherVendor = User::factory()->create(['role' => 'vendor']);
        $menuLain = Menu::create([
            'vendor_id' => $otherVendor->id,
            'name' => 'Menu Rahasia Vendor Lain',
            'description' => '...', 
            'calories' => 100, 
            'price' => 10000
        ]);

        $this->browse(function (Browser $browser) use ($menuLain) {
            $browser
                ->loginAs(static::$vendor)
                ->visit("/vendor/menu/" . $menuLain->id . "/edit")
                ->pause(1000)
                // Memastikan akses ditolak (403 Forbidden)
                ->assertSee('403') 
                ->screenshot("PBI-32-Security-Block-Access");
        });
    }

    /**
     * PBI-30: Tambah Menu (Testing Negative - Form Kosong)
     */
    public function test_vendor_gagal_tambah_menu_karena_validasi(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$vendor)
                ->visit("/vendor/menu/create")
                ->pause(1000)
                // Sengaja langsung klik simpan tanpa mengetik apapun
                ->press("SIMPAN MENU BARU")
                ->pause(1000)
                // Pastikan sistem menahan user tetap di halaman create (tidak masuk database)
                ->assertPathIs("/vendor/menu/create")
                ->screenshot("PBI-30-Negative-Validasi-Gagal");
        });
    }

    /**
     * PBI-31: Read Menu (Testing Negative - Otorisasi Role)
     */
    public function test_selain_vendor_tidak_bisa_akses_halaman_menu(): void
    {
        // Buat user palsu dengan role sekolah
        $sekolahUser = User::factory()->create(['role' => 'sekolah']);

        $this->browse(function (Browser $browser) use ($sekolahUser) {
            $browser
                ->loginAs($sekolahUser)
                ->visit("/vendor/menu")
                ->pause(1000)
                // Karena dilarang, sistem akan merender halaman error 403 di URL yang sama
                ->assertSee('403')
                ->screenshot("PBI-31-Negative-Bukan-Vendor");
        });
    }
}