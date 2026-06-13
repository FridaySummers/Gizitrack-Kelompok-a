<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Create.001
 * Menguji penambahan data user dengan data valid (Nama, Email, Role, Password, Konfirmasi Password)
 * Type: Positive
 */
class UserCreatePositiveTest extends DuskTestCase
{
    /**
     * TC.User.Create.001 - Admin berhasil menambah user baru dengan data valid.
     */
    public function testCreateUserWithValidData(): void
    {
        // Precondition: admin sudah login dan berada di halaman /admin/users
        $admin =
            User::where("role", "admin")->first() ??
            User::create([
                "name" => "Admin Test",
                "email" => "admin_create_pos_" . uniqid() . "@test.com",
                "password" => bcrypt("password123"),
                "role" => "admin",
            ]);

        $newName = "Vendor Dusk " . uniqid();
        $newEmail = "vendor_dusk_" . uniqid() . "@test.com";

        $this->browse(function (Browser $browser) use (
            $admin,
            $newName,
            $newEmail,
        ) {
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
            $browser->type("name", $newName);

            // Step 4: Type email valid unik pada field email — Field email terisi
            $browser->type("email", $newEmail);

            // Step 5: Select role "Admin" pada field role — Role berhasil dipilih
            $browser->select("role", "admin");

            // Step 6: Type password pada field password — Field password terisi
            $browser->type("password", "Password123!");

            // Step 7: Type password yang sama pada field password_confirmation
            $browser->type("password_confirmation", "Password123!");

            // Step 8: Click tombol "Simpan" — Data berhasil disimpan
            $browser->press("@submit-user")->pause(1500);

            // Step 9: AssertSee nama user di tabel — Data user muncul di list
            $browser->assertPathIs("/admin/users")->assertSee($newName);
        });
    }
}
