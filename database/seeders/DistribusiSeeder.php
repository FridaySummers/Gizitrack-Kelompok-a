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
        $vendor = \App\Models\User::where("role", "vendor")->first();
        $menu = \App\Models\Menu::first();

        if (!$sekolah1 || !$vendor || !$menu) {
            return;
        }

        $distribusis = [
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah2->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SMPN 15 Jakarta",
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah3->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SMA Cendekia",
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now()->subDays(2),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah4->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SD Muhammadiyah 2",
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now()->subDays(2),
                "status" => "Diterima Sebagian",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah2->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SMPN 15 Jakarta",
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Dikirim",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah3->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SMA Cendekia",
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now(),
                "status" => "Dikirim",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah1->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now(),
                "status" => "Dikirim",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah4->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SD Muhammadiyah 2",
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now(),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_id" => $sekolah2->id,
                "vendor_id" => $vendor->id,
                "menu_id" => $menu->id,
                "sekolah_tujuan" => "SMPN 15 Jakarta",
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now(),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
        ];

        foreach ($distribusis as $distribusi) {
            Distribusi::firstOrCreate(
                [
                    "sekolah_tujuan" => $distribusi["sekolah_tujuan"],
                    "tanggal_pengiriman" => $distribusi["tanggal_pengiriman"],
                ],
                $distribusi,
            );
        }
    }
}
