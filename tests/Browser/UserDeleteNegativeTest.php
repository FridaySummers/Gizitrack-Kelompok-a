<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

class UserDeleteNegativeTest extends AdminUserManagementDuskTestCase
{
    public function testDeleteUserCancelledByDialog(): void
    {
        $admin = $this->seederAdmin();

        $userToKeep = User::create([
            'name' => 'User To Keep Neg',
            'email' => 'user_del_neg_' . uniqid() . '@test.com',
            'password' => Hash::make('password123'),
            'role' => 'sekolah',
        ]);

        $keptName = $userToKeep->name;

        $this->browse(function (Browser $browser) use (
            $admin,
            $userToKeep,
            $keptName,
        ) {
            // Step 1
            $browser
                ->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('User To Keep Neg');

            // Step 2
            $browser
                ->press('@delete-user-' . $userToKeep->id)
                ->dismissDialog()
                ->pause(1000);

            // Step 3
            $browser
                ->assertPathIs('/admin/users')
                ->assertSee($keptName);

            // Step 4
            $browser->assertDontSee('Akun berhasil dihapus!');
        });
    }
}
