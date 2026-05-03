<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        // Distribution #4: SD Muhammadiyah 2, Diterima Sebagian
        $dist4 = Distribusi::where("sekolah_tujuan", "SD Muhammadiyah 2")
            ->whereDate("tanggal_pengiriman", now()->subDays(2))
            ->first();

        $sekolah4 = User::where("email", "sekolah4@gizitrack.test")->first();

        if ($dist4 && $sekolah4) {
            Feedback::firstOrCreate(
                [
                    "distribution_id" => $dist4->id,
                    "user_id" => $sekolah4->id,
                ],
                [
                    "catatan" =>
                        "Porsi yang diterima hanya 360 dari 380 yang dipesan. Terdapat kekurangan 20 porsi.",
                ],
            );
        }

        // Distribution #1: SDN 01 Pagi, Diterima
        $dist1 = Distribusi::where("sekolah_tujuan", "SDN 01 Pagi")
            ->whereDate("tanggal_pengiriman", now()->subDays(3))
            ->first();

        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();

        if ($dist1 && $sekolah) {
            Feedback::firstOrCreate(
                [
                    "distribution_id" => $dist1->id,
                    "user_id" => $sekolah->id,
                ],
                [
                    "catatan" =>
                        "Makanan diterima lengkap namun sayur sup kurang matang. Mohon diperhatikan kualitas masakan.",
                ],
            );
        }

        // Distribution #3: SMA Cendekia, Diterima
        $dist3 = Distribusi::where("sekolah_tujuan", "SMA Cendekia")
            ->whereDate("tanggal_pengiriman", now()->subDays(2))
            ->first();

        $sekolah3 = User::where("email", "sekolah3@gizitrack.test")->first();

        if ($dist3 && $sekolah3) {
            Feedback::firstOrCreate(
                [
                    "distribution_id" => $dist3->id,
                    "user_id" => $sekolah3->id,
                ],
                [
                    "catatan" =>
                        "Pengiriman tepat waktu dan porsi sesuai. Terima kasih.",
                ],
            );
        }
    }
}
