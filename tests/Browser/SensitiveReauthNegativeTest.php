<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;

/**
 * PBI-27 | TC.SensitiveReauth.002 — Negative
 *
 * Memvalidasi verifikasi ulang gagal saat admin memasukkan password salah;
 * form /admin/users/create tidak dapat diakses.
 *
 * Catatan: Test ini WAJIB dijalankan SEBELUM SensitiveReauthPositiveTest
 * (atau secara terpisah) agar session tidak mengandung auth.password_confirmed_at.
 */
class SensitiveReauthNegativeTest extends AdminUserManagementDuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Hapus SEMUA session dari DB/file agar auth.password_confirmed_at tidak carry-over
        // dari test lain yang sudah mengkonfirmasi password sebelumnya.
        $this->flushAllSessions();
    }

    /**
     * Hapus semua session yang tersimpan sehingga tidak ada password_confirmed_at
     * yang bisa carry-over ke browser session baru.
     */
    private function flushAllSessions(): void
    {
        // Jika session driver adalah 'database'
        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))->delete();
        }

        // Jika session driver adalah 'file', hapus semua file session
        if (config('session.driver') === 'file') {
            $path = config('session.files', storage_path('framework/sessions'));
            foreach (glob($path . '/*') as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    public function testWrongPasswordKeepsAdminOnConfirmationPage(): void
    {
        $admin = $this->seederAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            // Step 1 — loginAs membuat session baru; middleware harus trigger.
            $browser
                ->loginAs($admin)
                ->visit('/admin/users/create')
                ->pause(1500);

            // Step 2 — Halaman verifikasi ulang terbuka.
            $browser
                ->assertPathIs('/confirm-password')
                ->assertSee('VERIFIKASI KEAMANAN');

            // Step 3 — Password salah disubmit.
            $browser
                ->type('password', 'wrong-password')
                ->click('button[type="submit"]');

            $browser->pause(1000);

            // Step 4 — Verifikasi ditolak; tetap di halaman konfirmasi.
            $browser
                ->assertSee('The provided password is incorrect.')
                ->assertPathIs('/confirm-password');

            // Step 5 — Form tambah akun tidak dapat diakses.
            $browser->assertDontSee('Registrasi Akun Baru');

            $browser
                ->visit('/admin/users/create')
                ->pause(1500)
                ->assertPathIs('/confirm-password');
        });
    }
}
