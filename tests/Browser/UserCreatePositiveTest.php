<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

class UserCreatePositiveTest extends AdminUserManagementDuskTestCase
{
    public function testCreateUserWithValidData(): void
    {
        $admin = $this->seederAdmin();
        $newName = 'Katering Sehat Baru';
        $newEmail = 'vendor_baru_' . uniqid() . '@test.com';

        $this->browse(function (Browser $browser) use ($admin, $newName, $newEmail) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun Vendor & Sekolah');

            // Step 2
            $browser->clickLink('Tambah Akun Baru');
            $this->confirmPasswordIfRequired($browser);

            // Step 3
            $browser
                ->assertSee('Registrasi Akun Baru')
                ->assertPathIs('/admin/users/create');

            // Step 4
            $browser
                ->type('name', $newName)
                ->type('email', $newEmail)
                ->select('role', 'vendor')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!');

            // Step 5
            $browser
                ->press('@submit-user')
                ->waitForLocation('/admin/users');

            // Step 6
            $browser
                ->assertPathIs('/admin/users')
                ->assertSee('Akun berhasil didaftarkan!')
                ->assertSee($newName);
        });
    }
}
