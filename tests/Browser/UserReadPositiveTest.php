<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

class UserReadPositiveTest extends AdminUserManagementDuskTestCase
{
    public function testReadUserList(): void
    {
        $admin = $this->seederAdmin();
        $this->seederVendor();
        $this->seederSekolah();

        $this->browse(function (Browser $browser) use ($admin) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->waitFor('table');

            // Step 2
            $browser
                ->assertSee('Kelola Akun Vendor & Sekolah')
                ->assertSee('Nama Pengguna')
                ->assertSee('Role Akses');

            // Step 3
            $browser
                ->assertSee('Dapur Nusantara')
                ->assertSee('vendor@gizitrack.test')
                ->assertSee('Vendor');

            // Step 4
            $browser
                ->assertSee('SDN 01 Pagi')
                ->assertSee('sekolah@gizitrack.test')
                ->assertSee('Sekolah');

            // Step 5
            $browser
                ->assertSee('Admin GiziTrack')
                ->assertSee('Akun Anda')
                ->assertSee('Locked');

            // Step 6
            $browser
                ->assertPathIs('/admin/users')
                ->assertDontSee('Super Admin');
        });
    }
}
