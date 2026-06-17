<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

class UserCreateNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testCreateUserWithMismatchedPassword(): void
    {
        $admin = $this->seederAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            // Step 1
            $this->visitAdminUserCreateFormDirect($browser, $admin);

            // Step 2
            $browser
                ->type('name', 'Vendor Negative Test')
                ->type('email', 'vendor_neg_' . uniqid() . '@test.com')
                ->select('role', 'vendor')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'DifferentPassword!');

            // Step 3
            $browser->press('@submit-user')->pause(1000);

            // Step 4
            $browser
                ->assertSee('The password field confirmation does not match.')
                ->assertDontSee('Akun berhasil didaftarkan!');
        });
    }
}
