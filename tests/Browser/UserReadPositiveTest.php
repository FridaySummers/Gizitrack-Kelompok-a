<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * TC.User.Read.001
 * Menguji tampilan daftar user
 * Type: Positive
 */
class UserReadPositiveTest extends DuskTestCase
{
    /**
     * TC.User.Read.001 - Data user ditampilkan di tabel.
     */
    public function testReadUserList(): void
    {
        // Precondition: admin sudah login dan terdapat data user
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name'     => 'Admin Test',
                'email'    => 'admin_read_pos_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'admin',
            ]);

        // Pastikan ada minimal satu data user lain di database
        $sampleUser = User::where('role', '!=', 'admin')->first()
            ?? User::create([
                'name'     => 'Sample Vendor',
                'email'    => 'sample_vendor_' . uniqid() . '@test.com',
                'password' => bcrypt('password123'),
                'role'     => 'vendor',
            ]);

        $this->browse(function (Browser $browser) use ($admin, $sampleUser) {

            // Step 1: Visit /admin/users — Halaman daftar user ditampilkan
            $browser->loginAs($admin)
                ->visit('/admin/users')
                ->assertSee('Kelola Akun');

            // Step 2: Wait for table users — Tabel user muncul
            $browser->waitFor('table');

            // Step 3: AssertSee data user (nama/email/role) — Data user terlihat di tabel
            $browser->assertSee($sampleUser->name)
                ->assertSee($sampleUser->email);
        });
    }
}
