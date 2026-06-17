<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

/**
 * PBI-29 | TC.Profile.Unified.002 — Negative
 */
class ProfileUnifiedNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testNonNumericPhoneNumberIsRejectedOnProfileUpdate(): void
    {
        $vendor = $this->seederVendor();
        $vendor->forceFill(['name' => 'Dapur Nusantara', 'no_hp' => null])->save();

        $this->browse(function (Browser $browser) use ($vendor) {
            $browser
                ->loginAs($vendor)
                ->visit('/profile')
                ->pause(2000)
                ->assertSee('INFORMASI DASAR');

            // Step 1 — Isi no_hp dengan karakter non-numerik lalu submit.
            $browser
                ->clear('no_hp')
                ->type('no_hp', 'abc-invalid')
                ->click('main button[type="submit"]')
                ->pause(2000);

            // Step 2 — Tangani password.confirm jika diminta.
            $currentPath = parse_url($browser->driver->getCurrentURL(), PHP_URL_PATH) ?? '';
            if (str_contains($currentPath, 'confirm-password')) {
                $browser
                    ->type('password', 'password')
                    ->click('button[type="submit"]')
                    ->pause(2000);
                
                // Setelah password dikonfirmasi, kita kembali ke form. Submit ulang data invalid.
                $browser
                    ->clear('no_hp')
                    ->type('no_hp', 'abc-invalid')
                    ->click('main button[type="submit"]')
                    ->pause(2000);
            }

            // Step 3 — Update ditolak; pesan error validasi tampil.
            $browser
                ->assertPathIs('/profile')
                ->assertSee('The no hp field must be a number.')
                ->assertDontSee('DATA BERHASIL DISINKRONKAN');

            // Step 4 — Data profil tidak berubah di database.
            $this->assertDatabaseMissing('users', [
                'id' => $vendor->id,
                'no_hp' => 'abc-invalid',
            ]);
        });
    }
}
