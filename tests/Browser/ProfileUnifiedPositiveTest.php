<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

/**
 * PBI-29 | TC.Profile.Unified.001 — Positive
 *
 * Memvalidasi update profil tersentralisasi: perubahan name, no_hp, dan alamat
 * langsung tersimpan di tabel users via /profile.
 */
class ProfileUnifiedPositiveTest extends AdminUserManagementDuskTestCase
{
    public function testVendorCanUpdateProfileAndChangesPersist(): void
    {
        $vendor = $this->seederVendor();
        // Reset data ke kondisi awal sebelum test.
        $vendor->forceFill(['name' => 'Dapur Nusantara', 'no_hp' => null, 'alamat' => null])->save();

        $this->browse(function (Browser $browser) use ($vendor) {
            // Step 1 — Halaman profil terbuka; email tampil readonly.
            // "Profile Saya" muncul di sidebar nav link (bukan heading utama).
            $browser
                ->loginAs($vendor)
                ->visit('/profile')
                ->pause(2000)
                ->assertSee('INFORMASI DASAR');

            // Step 2 — Email tidak dapat diubah (readonly).
            $browser->assertInputValue('email', 'vendor@gizitrack.test');

            // Step 3 — Isi field identitas dengan data baru.
            $browser
                ->clear('name')
                ->type('name', 'Dapur Nusantara Updated')
                ->clear('no_hp')
                ->type('no_hp', '081234567890')
                ->clear('alamat')
                ->type('alamat', 'Jl. Gizi Sehat No. 10, Jakarta');

            // Step 4 — Tekan simpan; tangani confirm-password jika diminta.
            $browser->click('main button[type="submit"]');
            $browser->pause(2000);
            $this->confirmPasswordIfRequired($browser);

            // Jika setelah confirm-password kembali ke profile, isi ulang dan submit.
            $currentPath = parse_url($browser->driver->getCurrentURL(), PHP_URL_PATH) ?? '';
            if (str_contains($currentPath, 'profile')) {
                $browser
                    ->pause(1000)
                    ->clear('name')
                    ->type('name', 'Dapur Nusantara Updated')
                    ->clear('no_hp')
                    ->type('no_hp', '08123456789')
                    ->clear('alamat')
                    ->type('alamat', 'Jl. Vendor Baru 123')
                    ->click('main button[type="submit"]')
                    ->pause(2000);
            }

            // Step 5 — Flash sukses tampil.
            $browser
                ->assertPathIs('/profile')
                ->assertSee('DATA BERHASIL DISINKRONKAN');

            // Step 4 — Cek database perubahan tersimpan
            $this->assertDatabaseHas('users', [
                'id' => $vendor->id,
                'no_hp' => '08123456789',
                'alamat' => 'Jl. Vendor Baru 123',
            ]);

            // Step 6 — Data persisten setelah reload.
            $browser
                ->refresh()
                ->pause(1500)
                ->assertSee('Dapur Nusantara Updated')
                ->assertInputValue('no_hp', '08123456789')
                ->assertInputValue('alamat', 'Jl. Vendor Baru 123');
        });

        // Kembalikan data vendor ke kondisi semula.
        $vendor->refresh()->forceFill(['name' => 'Dapur Nusantara', 'no_hp' => null, 'alamat' => null])->save();
    }
}
