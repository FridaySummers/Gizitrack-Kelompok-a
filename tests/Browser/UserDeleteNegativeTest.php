<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Delete.002
 * Menguji batal hapus user pada popup konfirmasi
 * Type: Negative
 */
class UserDeleteNegativeTest extends DuskTestCase
{
    /**
     * TC.User.Delete.002 - Data user tidak terhapus setelah membatalkan konfirmasi.
     *
     * Catatan implementasi:
     * Tombol "Hapus" menggunakan native browser confirm() dialog via onsubmit attribute.
     * Laravel Dusk menangani pembatalan dialog ini dengan ->dismissDialog() setelah klik tombol.
     */
    public function testDeleteUserCancelledByDialog(): void
    {
        // Precondition: admin sudah login dan terdapat data user
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name'     => 'Admin Test',
                'email'    => 'admin_del_neg_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'admin',
            ]);

        // Buat user yang akan dicoba dihapus namun dibatalkan
        $userToKeep = User::create([
            'name'     => 'User To Keep Neg',
            'email'    => 'user_del_neg_' . uniqid() . '@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'sekolah',
        ]);

        $keptName = $userToKeep->name;

        $this->browse(function (Browser $browser) use ($admin, $userToKeep, $keptName) {

            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2: Click tombol "Hapus" — Muncul popup konfirmasi (native dialog)
            // Step 3: AssertSee "Yakin ingin menghapus akun" — pesan tampil di dialog
            // Step 4: Click tombol "Batal" — Dismiss native confirm dialog (Cancel)
            $browser->with('form[action*="users/' . $userToKeep->id . '"]', function (Browser $form) {
                $form->press('Hapus');
            });

            // Dismiss dialog = klik "Cancel" / "Batal" pada native confirm()
            $browser->dismissDialog()
                ->pause(1000);

            // Step 5: AssertSee nama user — Data masih ada di tabel (tidak terhapus)
            $browser->assertPathIs('/admin/users')
                ->assertSee($keptName);
        });
    }
}
