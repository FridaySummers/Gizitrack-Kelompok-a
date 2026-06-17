<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

class UserReadNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testVendorCannotAccessAdminUserList(): void
    {
        $vendor = $this->seederVendor();
        $this->seederAdmin();

        $this->browse(function (Browser $browser) use ($vendor) {
            // Step 1
            $browser->loginAs($vendor)->visit('/admin/users');

            // Step 2
            $browser->assertSee('403')->assertSee('Otoritas Ditolak');

            // Step 3
            $browser
                ->assertDontSee('Kelola Akun Vendor & Sekolah')
                ->assertDontSee('Tambah Akun Baru');

            // Step 4
            $browser->assertDontSee('Dapur Nusantara');
        });
    }
}
