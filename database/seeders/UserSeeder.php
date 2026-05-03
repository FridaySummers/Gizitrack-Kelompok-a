<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ["email" => "admin@gizitrack.test"],
            [
                "name" => "Admin GiziTrack",
                "password" => Hash::make("password"),
                "role" => "admin",
            ],
        );

        // Vendors
        User::firstOrCreate(
            ["email" => "vendor@gizitrack.test"],
            [
                "name" => "Dapur Nusantara",
                "password" => Hash::make("password"),
                "role" => "vendor",
            ],
        );

        User::firstOrCreate(
            ["email" => "vendor2@gizitrack.test"],
            [
                "name" => "Katering Ibu Hani",
                "password" => Hash::make("password"),
                "role" => "vendor",
            ],
        );

        User::firstOrCreate(
            ["email" => "vendor3@gizitrack.test"],
            [
                "name" => "CV Boga Sehat",
                "password" => Hash::make("password"),
                "role" => "vendor",
            ],
        );

        // Sekolah
        User::firstOrCreate(
            ["email" => "sekolah@gizitrack.test"],
            [
                "name" => "SDN 01 Pagi",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );

        User::firstOrCreate(
            ["email" => "sekolah2@gizitrack.test"],
            [
                "name" => "SMPN 15 Jakarta",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );

        User::firstOrCreate(
            ["email" => "sekolah3@gizitrack.test"],
            [
                "name" => "SMA Cendekia",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );

        User::firstOrCreate(
            ["email" => "sekolah4@gizitrack.test"],
            [
                "name" => "SD Muhammadiyah 2",
                "password" => Hash::make("password"),
                "role" => "sekolah",
            ],
        );
    }
}
