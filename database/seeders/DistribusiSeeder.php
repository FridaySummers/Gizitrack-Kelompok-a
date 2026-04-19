<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Distribusi::create([
            'sekolah_tujuan' => 'SD Negeri 1 Jakarta',
            'jumlah_porsi' => 100,
            'tanggal_pengiriman' => '2026-04-20',
            'status' => 'Di Perjalanan',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'last_updated' => now(),
        ]);

        Distribusi::create([
            'sekolah_tujuan' => 'SD Negeri 2 Bandung',
            'jumlah_porsi' => 150,
            'tanggal_pengiriman' => '2026-04-21',
            'status' => 'Terkirim',
            'latitude' => -6.9175,
            'longitude' => 107.6191,
            'last_updated' => now()->subMinutes(5),
        ]);

        Distribusi::create([
            'sekolah_tujuan' => 'SD Negeri 3 Surabaya',
            'jumlah_porsi' => 200,
            'tanggal_pengiriman' => '2026-04-22',
            'status' => 'Pending',
            'latitude' => null,
            'longitude' => null,
            'last_updated' => null,
        ]);
    }
}
