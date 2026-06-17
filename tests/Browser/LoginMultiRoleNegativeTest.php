<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

class LoginMultiRoleNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testLoginFailsAndUserRemainsOnLoginPage(): void
    {
        $this->seederVendor();

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/login')
                ->pause(1500)
                ->assertSee('Selamat Datang');

            $browser
                ->type('email', 'vendor@gizitrack.test')
                ->type('password', 'wrong-password')
                ->press('@login-button')
                ->pause(1500);

            $browser
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');

            $browser
                ->assertDontSee('Dashboard Vendor')
                ->assertDontSee('Kelola Akun Vendor & Sekolah');
        });
    }
}
