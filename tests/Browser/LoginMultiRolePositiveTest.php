<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

/**
 * PBI-28 | TC.Login.MultiRole.001 — Positive
 *
 * Memvalidasi login multi-role: vendor setelah login langsung redirect ke
 * /vendor/dashboard sesuai enum role.
 */
class LoginMultiRolePositiveTest extends AdminUserManagementDuskTestCase
{
    public function testVendorIsRedirectedToVendorDashboardAfterLogin(): void
    {
        $this->seederVendor();

        $this->browse(function (Browser $browser) {
            // Step 1 — Buka halaman login.
            // Browser mode incognito sudah memastikan tidak ada session lama.
            $browser
                ->visit('/login')
                ->pause(1500)
                ->assertSee('Selamat Datang');

            // Step 2 — Submit kredensial valid.
            $browser
                ->type('email', 'vendor@gizitrack.test')
                ->type('password', 'password')
                ->press('@login-button');

            // Step 3 — Redirect ke dashboard vendor.
            $browser
                ->waitForLocation('/vendor/dashboard', 10)
                ->assertPathIs('/vendor/dashboard');

            // Step 4 — Konten dashboard vendor tampil.
            $browser
                ->assertSee('DASHBOARD VENDOR')
                ->assertSee('Dapur Nusantara');

            // Step 5 — Akses admin tertutup untuk vendor (403).
            $browser
                ->visit('/admin/users')
                ->pause(1000)
                ->assertSee('403')
                ->assertSee('OTORITAS DITOLAK');
        });
    }
}
