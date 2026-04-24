<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;

class VendorMenuTest extends TestCase
{
    // Wajib ada biar database bayangan di-reset tiap kali tes jalan
    use RefreshDatabase; 

    /**
     * Fungsi bantuan untuk membuat user dengan role vendor (Tanpa Factory)
     */
    private function createVendorUser()
    {
        // Kita bikin user-nya pakai cara manual biar nggak kena error factory
        return User::create([
            'name' => 'Vendor Tester',
            'email' => 'vendor_tester@gizitrack.com',
            'password' => bcrypt('rahasia123'),
            'role' => 'vendor',
        ]);
    }

    /**
     * 1. Test Read: Pastikan vendor bisa melihat halaman index menu (Katalog Menu)
     */
    public function test_vendor_can_view_menu_index()
    {
        $vendor = $this->createVendorUser();

        // Pura-pura login jadi vendor, lalu buka halaman index
        $response = $this->actingAs($vendor)->get(route('vendor.menu.index'));

        // Pastikan statusnya 200 (OK/Sukses dimuat)
        $response->assertStatus(200);
    }

    /**
     * 2. Test Create: Pastikan vendor bisa menyimpan menu baru
     */
    public function test_vendor_can_store_new_menu()
    {
        $vendor = $this->createVendorUser();

        // Data bohongan untuk di-input ke form tambah menu
        $menuData = [
            'name' => 'Ayam Geprek Spesial',
            'description' => 'Ayam geprek level 5 tambah es teh',
            'calories' => 600,
            'price' => 20000,
        ];

        // Pura-pura login, lalu submit form POST ke rute store
        $response = $this->actingAs($vendor)->post(route('vendor.menu.store'), $menuData);

        // Habis simpan, pastikan di-redirect kembali ke halaman index
        $response->assertRedirect(route('vendor.menu.index'));

        // Pastikan data beneran masuk ke tabel 'menus' di database bayangan
        $this->assertDatabaseHas('menus', [
            'name' => 'Ayam Geprek Spesial',
            'calories' => 600,
        ]);
    }

    /**
     * 3. Test Update: Pastikan vendor bisa mengedit menu yang sudah ada
     */
    public function test_vendor_can_update_menu()
    {
        $vendor = $this->createVendorUser();

        // Bikin menu awal dulu di database
        $menu = Menu::create([
            'name' => 'Telur Dadar Lama',
            'description' => 'Deskripsi lama',
            'calories' => 100,
            'price' => 5000,
        ]);

        // Data baru untuk menimpa yang lama
        $updateData = [
            'name' => 'Telur Dadar Baru',
            'description' => 'Deskripsi sudah diupdate',
            'calories' => 150,
            'price' => 7000,
        ];

        // Pura-pura login, lalu submit form PUT ke rute update
        $response = $this->actingAs($vendor)->put(route('vendor.menu.update', $menu->id), $updateData);

        // Pastikan di-redirect ke index
        $response->assertRedirect(route('vendor.menu.index'));

        // Pastikan nama barunya beneran tersimpan di database
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Telur Dadar Baru',
        ]);
    }

    /**
     * 4. Test Delete: Pastikan vendor bisa menghapus menu
     */
    public function test_vendor_can_delete_menu()
    {
        $vendor = $this->createVendorUser();

        // Bikin menu yang jadi target untuk dihapus
        $menu = Menu::create([
            'name' => 'Menu Siap Hapus',
            'description' => 'Akan dihapus oleh test',
            'calories' => 50,
            'price' => 2000,
        ]);

        // Pura-pura login, lalu hit tombol DELETE
        $response = $this->actingAs($vendor)->delete(route('vendor.menu.destroy', $menu->id));

        // Pastikan di-redirect ke index
        $response->assertRedirect(route('vendor.menu.index'));

        // Pastikan datanya beneran HILANG dari database
        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id,
        ]);
    }
}