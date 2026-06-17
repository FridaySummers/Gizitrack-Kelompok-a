<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

class UserDeletePositiveTest extends AdminUserManagementDuskTestCase
{
    public function testDeleteUserWithConfirmation(): void
    {
        $admin = $this->seederAdmin();

        $userToDelete = User::create([
            'name' => 'User To Delete Pos',
            'email' => 'user_del_pos_' . uniqid() . '@test.com',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
        ]);

        $deletedName = $userToDelete->name;

        $this->browse(function (Browser $browser) use (
            $admin,
            $userToDelete,
            $deletedName,
        ) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('User To Delete Pos');

            // Step 2
            $browser
                ->press('@delete-user-' . $userToDelete->id)
                ->acceptDialog();

            // Step 3
            $browser
                ->waitForLocation('/admin/users')
                ->assertPathIs('/admin/users');

            // Step 4
            $browser
                ->assertSee('Akun berhasil dihapus!')
                ->assertDontSee($deletedName);
        });
    }
}
