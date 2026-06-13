<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Create.002
 * Menguji penambahan user dengan konfirmasi password tidak sesuai
 * Type: Negative
 */
class UserCreateNegativeTest extends DuskTestCase
{
    /**
     * TC.User.Create.002 - Data gagal disimpan karena konfirmasi password tidak sesuai.
     */
    public function testCreateUserWithMismatchedPassword(): void
    {
        // Precondition: admin sudah login
        $admin =
            User::where("role", "admin")->first() ??
            User::create([
                "name" => "Admin Test",
                "email" => "admin_create_neg_" . uniqid() . "@test.com",
                "password" => bcrypt("password123"),
                "role" => "admin",
            ]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser
                ->loginAs($admin)
                ->visit("/admin/users")
                ->assertSee("Kelola Akun");

            // Step 2: Click tombol "Tambah Akun" — Form create user ditampilkan
            $browser
                ->clickLink("Tambah Akun Baru")
                ->assertSee("REGISTRASI AKUN BARU");

            // Step 3: Type nama pada field name — Field name terisi
            $browser->type("name", "Vendor Negative Test");

            // Step 4: Type email valid pada field email — Field email terisi
            $browser->type("email", "vendor_neg_" . uniqid() . "@test.com");

            // Step 5: Select role "Vendor" pada field role — Role berhasil dipilih
            $browser->select("role", "vendor");

            // Step 6: Type password pada field password — Field password terisi
            $browser->type("password", "Password123!");

            // Step 7: Type password berbeda pada field password_confirmation — Konfirmasi tidak sesuai
            $browser->type("password_confirmation", "DifferentPassword!");

            // Step 8: Click tombol "Simpan" — Validasi gagal
            $browser->press("@submit-user")->pause(1000);

            // Step 9: AssertSee pesan error konfirmasi password tidak cocok
            // Laravel's English validation message for 'confirmed' rule:
            $browser->assertSee(
                "The password field confirmation does not match.",
            );
        });
    }
}
