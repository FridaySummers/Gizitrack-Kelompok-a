<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

/**
 * PBI-27 | TC.SensitiveReauth.001 — Positive
 */
class SensitiveReauthPositiveTest extends AdminUserManagementDuskTestCase
{
    public function testMiddlewarePasswordConfirmRedirectsAndAllowsAccessAfterCorrectPassword(): void
    {
        $admin = $this->seederAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->pause(1500)
                ->assertSee('Kelola Akun Vendor & Sekolah');

            $browser
                ->clickLink('Tambah Akun Baru')
                ->pause(1500);

            $browser
                ->assertPathIs('/confirm-password')
                ->assertSee('VERIFIKASI KEAMANAN') // CSS uppercase renders this in uppercase
                ->assertSee('AREA SENSITIF: KONFIRMASI KATA SANDI');

            $browser->assertSee('Harap verifikasi ulang kata sandi Anda untuk melanjutkan tindakan ini.');

            $browser
                ->type('password', 'password')
                ->click('button[type="submit"]');

            $browser
                ->waitForLocation('/admin/users/create', 10)
                ->assertPathIs('/admin/users/create')
                ->assertSee('REGISTRASI AKUN BARU');
        });
    }
}
