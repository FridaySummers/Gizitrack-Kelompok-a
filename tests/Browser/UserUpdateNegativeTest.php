<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

class UserUpdateNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testUpdateUserWithMismatchedPassword(): void
    {
        $admin = $this->seederAdmin();

        $targetUser = User::create([
            'name' => 'User Update Neg Test',
            'email' => 'user_upd_neg_' . uniqid() . '@test.com',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users/' . $targetUser->id . '/edit')
                ->assertSee('Perbarui Informasi Akun');

            // Step 2
            $browser
                ->clear('name')
                ->type('name', 'Updated Name Neg')
                ->type('password', 'NewPassword123!')
                ->type('password_confirmation', 'DifferentPassword!');

            // Step 3
            $browser->press('@update-user')->pause(1000);

            // Step 4
            $browser
                ->assertSee('The password field confirmation does not match.')
                ->assertDontSee('Data akun berhasil diperbarui!');
        });
    }
}
