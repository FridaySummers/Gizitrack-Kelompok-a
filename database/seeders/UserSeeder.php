<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin GiziTrack',
            'email'    => 'admin@gizitrack.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Vendor Sample',
            'email'    => 'vendor@gizitrack.test',
            'password' => Hash::make('password'),
            'role'     => 'vendor',
        ]);

        User::create([
            'name'     => 'SDN 01 Pagi',
            'email'    => 'sekolah@gizitrack.test',
            'password' => Hash::make('password'),
            'role'     => 'sekolah',
        ]);
    }
}