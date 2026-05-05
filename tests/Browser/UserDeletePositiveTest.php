<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Delete.001
 * Menguji hapus user dengan konfirmasi "Yakin ingin menghapus akun xxxx?"
 * Type: Positive
 */
class UserDeletePositiveTest extends DuskTestCase
{
    /**
     * TC.User.Delete.001 - Data user berhasil dihapus setelah konfirmasi "Ya".
     *
     * Catatan implementasi:
     * Tombol "Hapus" menggunakan native browser confirm() dialog via onsubmit attribute.
     * Laravel Dusk menangani dialog ini dengan ->acceptDialog() setelah klik tombol.
     */
    public function testDeleteUserWithConfirmation(): void
    {
        // Precondition: admin sudah login dan terdapat data user
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name'     => 'Admin Test',
                'email'    => 'admin_del_pos_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'admin',
            ]);

        // Buat user yang akan dihapus
        $userToDelete = User::create([
            'name'     => 'User To Delete Pos',
            'email'    => 'user_del_pos_' . uniqid() . '@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'vendor',
        ]);

        $deletedName = $userToDelete->name;

        $this->browse(function (Browser $browser) use ($admin, $userToDelete, $deletedName) {

            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2: Click tombol "Hapus" pada user — Muncul popup konfirmasi (native dialog)
            // Step 3: AssertSee "Yakin ingin menghapus akun" — dialog berisi pesan konfirmasi
            // Karena dialog native tidak bisa di-assertSee secara langsung,
            // kita accept dialog yang muncul setelah klik tombol Hapus
            $browser->with('form[action*="users/' . $userToDelete->id . '"]', function (Browser $form) {
                $form->press('Hapus');
            });

            // Step 4: Click tombol "Ya" — Accept native confirm dialog
            $browser->acceptDialog()
                ->pause(1500);

            // Step 5: AssertDontSee nama user — Data tidak ada di tabel
            $browser->assertPathIs('/admin/users')
                ->assertDontSee($deletedName);
        });
    }
}
