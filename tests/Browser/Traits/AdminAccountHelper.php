<?php

namespace Tests\Browser\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

trait AdminAccountHelper
{
    protected function seederAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@gizitrack.test'],
            [
                'name' => 'Admin GiziTrack',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        );
    }

    protected function seederVendor(): User
    {
        return User::firstOrCreate(
            ['email' => 'vendor@gizitrack.test'],
            [
                'name' => 'Dapur Nusantara',
                'password' => Hash::make('password'),
                'role' => 'vendor',
            ],
        );
    }

    protected function seederSekolah(): User
    {
        return User::firstOrCreate(
            ['email' => 'sekolah@gizitrack.test'],
            [
                'name' => 'SDN 01 Pagi',
                'password' => Hash::make('password'),
                'role' => 'sekolah',
            ],
        );
    }

    protected function openAdminUserCreateForm(
        Browser $browser,
        User $admin,
        string $password = 'password',
    ): void {
        $browser
            ->loginAs($admin)
            ->visit('/admin/users')
            ->clickLink('Tambah Akun Baru');

        $this->confirmPasswordIfRequired($browser, $password);

        $browser
            ->assertPathIs('/admin/users/create')
            ->assertSee('Registrasi Akun Baru');
    }

    protected function visitAdminUserCreateFormDirect(
        Browser $browser,
        User $admin,
        string $password = 'password',
    ): void {
        $browser->loginAs($admin)->visit('/admin/users/create');

        $this->confirmPasswordIfRequired($browser, $password);

        $browser
            ->assertPathIs('/admin/users/create')
            ->assertSee('Registrasi Akun Baru');
    }

    protected function confirmPasswordIfRequired(
        Browser $browser,
        string $password = 'password',
    ): void {
        $path = parse_url($browser->driver->getCurrentURL(), PHP_URL_PATH) ?? '';

        if (str_contains($path, 'confirm-password')) {
            $browser
                ->type('password', $password)
                ->click('button[type="submit"]')
                ->pause(2000);
        }
    }
}
