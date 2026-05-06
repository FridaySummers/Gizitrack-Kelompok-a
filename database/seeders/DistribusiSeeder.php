<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistribusiSeeder extends Seeder
{
    public function run(): void
    {
        $distribusis = [
            [
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SMPN 15 Jakarta",
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->subDays(3),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SMA Cendekia",
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now()->subDays(2),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SD Muhammadiyah 2",
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now()->subDays(2),
                "status" => "Diterima Sebagian",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Diterima",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SMPN 15 Jakarta",
                "jumlah_porsi" => 620,
                "tanggal_pengiriman" => now()->subDays(1),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SMA Cendekia",
                "jumlah_porsi" => 480,
                "tanggal_pengiriman" => now(),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SDN 01 Pagi",
                "jumlah_porsi" => 450,
                "tanggal_pengiriman" => now(),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
            [
                "sekolah_tujuan" => "SD Muhammadiyah 2",
                "jumlah_porsi" => 380,
                "tanggal_pengiriman" => now(),
                "status" => "Di Perjalanan",
                "catatan_kendala" => null,
            ],
            [
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
