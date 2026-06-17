<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

class UserUpdatePositiveTest extends AdminUserManagementDuskTestCase
{
    public function testUpdateUserWithValidData(): void
    {
        $admin = $this->seederAdmin();

        $targetUser = User::create([
            'name' => 'User Before Update',
            'email' => 'user_update_' . uniqid() . '@test.com',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
        ]);

        $updatedName = 'User After Update';
        $updatedEmail = 'user_updated_' . uniqid() . '@test.com';

        $this->browse(function (Browser $browser) use (
            $admin,
            $targetUser,
            $updatedName,
            $updatedEmail,
        ) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2
            $browser
                ->visit('/admin/users/' . $targetUser->id . '/edit')
                ->assertSee('Perbarui Informasi Akun');

            // Step 3
            $browser
                ->clear('name')
                ->type('name', $updatedName)
                ->clear('email')
                ->type('email', $updatedEmail)
                ->select('role', 'sekolah');

            // Step 4
            $browser
                ->press('@update-user')
                ->waitForLocation('/admin/users');

            // Step 5
            $browser
                ->assertPathIs('/admin/users')
                ->assertSee('Data akun berhasil diperbarui!')
                ->assertSee($updatedName);
        });
    }
}
