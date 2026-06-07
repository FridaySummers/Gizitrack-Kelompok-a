<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistribusiSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah1 = \App\Models\User::where(
            "email",
            "sekolah@gizitrack.test",
        )->first();
        $sekolah2 = \App\Models\User::where(
            "email",
            "sekolah2@gizitrack.test",
        )->first();
        $sekolah3 = \App\Models\User::where(
            "email",
            "sekolah3@gizitrack.test",
        )->first();
        $sekolah4 = \App\Models\User::where(
            "email",
            "sekolah4@gizitrack.test",
        )->first();

        $vendor1 = \App\Models\User::where(
            "email",
            "vendor@gizitrack.test",
        )->first();
        $vendor2 = \App\Models\User::where(
            "email",
            "vendor2@gizitrack.test",
        )->first();

        $menu1 = \App\Models\Menu::first();
        $menu2 = \App\Models\Menu::skip(1)->first() ?? $menu1;

        if (!$sekolah1 || !$vendor1 || !$menu1) {
            return;
        }

        $distribusis = [
            // History (Diterima)
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah2->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah2->name,
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah4->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah4->name,
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now()->subDays(2),
                "status" => "Diterima Sebagian",
                "catatan_kendala" => "10 porsi rusak",
            ],

            // Yesterday (Diterima/Kendala)
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah3->id,
                "vendor_id" => $vendor2->id,
                "menu_id" => $menu2->id,
                "sekolah_tujuan" => $sekolah3->name,
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Kendala",
                "catatan_kendala" => "Ban mobil pecah",
            ],

            // Today (Ongoing / Monitoring for sekolah1)
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Dikirim",
                "latitude" => -6.175392,
                "longitude" => 106.827153,
                "last_updated" => now(),
            ],
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 200,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Di Perjalanan",
                "latitude" => -6.1944,
                "longitude" => 106.8229,
                "last_updated" => now(),
            ],
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 150,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Di Perjalanan",
                "latitude" => -6.2297,
                "longitude" => 106.8164,
                "last_updated" => now(),
            ],

            // Other schools
            [
                "sekolah_id" => $sekolah2->id,
                "vendor_id" => $vendor1->id,
                "menu_id" => $menu1->id,
                "sekolah_tujuan" => $sekolah2->name,
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Di Perjalanan",
                "latitude" => -6.1944,
                "longitude" => 106.8229,
                "last_updated" => now(),
            ],
            [
                "sekolah_id" => $sekolah3->id,
                "vendor_id" => $vendor2->id,
                "menu_id" => $menu2->id,
                "sekolah_tujuan" => $sekolah3->name,
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Di Perjalanan",
                "latitude" => -6.2297,
                "longitude" => 106.8164, // SCBD
                "last_updated" => now(),
            ],
            [
                "sekolah_id" => $sekolah4->id,
                "vendor_id" => $vendor2->id,
                "menu_id" => $menu2->id,
                "sekolah_tujuan" => $sekolah4->name,
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now()->toDateString(),
                "status" => "Dikirim",
                "latitude" => -6.2088,
                "longitude" => 106.8456, // Menteng
                "last_updated" => now(),
            ],
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor2->id,
                "menu_id" => $menu2->id,
                "sekolah_tujuan" => $sekolah1->name,
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->addDay()->toDateString(),
                "status" => "Pending",
                "catatan_kendala" => null,
            ],
        ];

        foreach ($distribusis as $distribusi) {
            Distribusi::updateOrCreate(
                [
                    "sekolah_id" => $distribusi["sekolah_id"],
                    "tanggal_pengiriman" => $distribusi["tanggal_pengiriman"],
                    "status" => $distribusi["status"],
                    "jumlah_porsi" => $distribusi["jumlah_porsi"],
                ],
                $distribusi,
            );
        }
    }
}
