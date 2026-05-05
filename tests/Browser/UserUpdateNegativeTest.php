<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Update.002
 * Menguji update user dengan konfirmasi password tidak sesuai
 * Type: Negative
 */
class UserUpdateNegativeTest extends DuskTestCase
{
    /**
     * TC.User.Update.002 - Update gagal dan muncul error validasi konfirmasi password.
     */
    public function testUpdateUserWithMismatchedPassword(): void
    {
        // Precondition: admin sudah login dan terdapat data user
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name'     => 'Admin Test',
                'email'    => 'admin_update_neg_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'admin',
            ]);

        // Buat user yang akan dicoba diedit
        $targetUser = User::create([
            'name'     => 'User Update Neg Test',
            'email'    => 'user_upd_neg_' . uniqid() . '@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'vendor',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {

            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2: Click tombol "Edit" — Form edit ditampilkan
            $browser->visit('/admin/users/' . $targetUser->id . '/edit')
                ->assertSee('Edit Akun');

            // Step 3: Update field name — Field name berubah
            $browser->clear('name')
                ->type('name', 'Updated Name Neg');

            // Step 4: Type password baru pada field password — Field password terisi
            $browser->type('password', 'NewPassword123!');

            // Step 5: Type password berbeda pada field password_confirmation — Konfirmasi tidak sesuai
            $browser->type('password_confirmation', 'DifferentPassword!');

            // Step 6: Click tombol "Update Akun" — Validasi gagal
            $browser->press('Update Akun')
                ->pause(1000);

            // Step 7: AssertSee pesan error konfirmasi password tidak cocok
            // Laravel's English validation message for 'confirmed' rule:
            $browser->assertSee('The password field confirmation does not match.');
        });
    }
}
