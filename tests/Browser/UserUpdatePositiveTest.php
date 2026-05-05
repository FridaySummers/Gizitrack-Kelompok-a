<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Update.001
 * Menguji update data user dengan data valid (termasuk role dan password)
 * Type: Positive
 */
class UserUpdatePositiveTest extends DuskTestCase
{
    /**
     * TC.User.Update.001 - Data user berhasil diperbarui.
     */
    public function testUpdateUserWithValidData(): void
    {
        // Precondition: admin sudah login dan terdapat data user
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name'     => 'Admin Test',
                'email'    => 'admin_update_pos_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'admin',
            ]);

        // Buat user yang akan diedit
        $targetUser = User::create([
            'name'     => 'User Before Update',
            'email'    => 'user_update_' . uniqid() . '@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'vendor',
        ]);

        $updatedName = 'User After Update ' . uniqid();

        $this->browse(function (Browser $browser) use ($admin, $targetUser, $updatedName) {

            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2: Click tombol "Edit" pada salah satu user — Form edit ditampilkan
            $browser->visit('/admin/users/' . $targetUser->id . '/edit')
                ->assertSee('Edit Akun');

            // Step 3: Update field name — Field name berubah
            $browser->clear('name')
                ->type('name', $updatedName);

            // Step 4: Select role "Sekolah" pada field role — Role berhasil diubah
            $browser->select('role', 'sekolah');

            // Step 5: Type password baru pada field password — Password terisi
            $browser->type('password', 'NewPassword123!');

            // Step 6: Type password sama pada field password_confirmation — Konfirmasi sesuai
            $browser->type('password_confirmation', 'NewPassword123!');

            // Step 7: Click tombol "Update Akun" — Data berhasil diperbarui
            $browser->press('Update Akun')
                ->pause(1500);

            // Step 8: AssertSee nama baru di tabel — Data berhasil berubah
            $browser->assertPathIs('/admin/users')
                ->assertSee($updatedName);
        });
    }
}
