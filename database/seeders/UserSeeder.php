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
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Vendor Sample',
            'email'    => 'vendor@gmail.com',
            'password' => Hash::make('vendor123'),
            'role'     => 'vendor',
        ]);

        User::create([
            'name'     => 'SDN 01 Pagi',
            'email'    => 'sekolah@gmail.com',
            'password' => Hash::make('sekolah123'),
            'role'     => 'sekolah',
        ]);
    }
}