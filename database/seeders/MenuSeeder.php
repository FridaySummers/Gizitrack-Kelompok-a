<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $vendor1 = \App\Models\User::where(
            "email",
            "vendor@gizitrack.test",
        )->first();
        $vendor2 = \App\Models\User::where(
            "email",
            "vendor2@gizitrack.test",
        )->first();
        $vendor3 = \App\Models\User::where(
            "email",
            "vendor3@gizitrack.test",
        )->first();

        if (!$vendor1) {
            return;
        }

        $menus = [
            // Vendor 1 Menus
            [
                "vendor_id" => $vendor1->id,
                "name" => "Nasi Ayam Bakar + Sayur Sup",
                "description" =>
                    "Ayam bakar dengan bumbu kecap manis, disajikan dengan sup sayuran segar",
                "calories" => 520,
                "price" => 25000,
            ],
            [
                "vendor_id" => $vendor1->id,
                "name" => "Nasi Telur Dadar + Capcay",
                "description" =>
                    "Telur dadar tebal dengan sayuran capcay tumis",
                "calories" => 480,
                "price" => 20000,
            ],
            [
                "vendor_id" => $vendor1->id,
                "name" => "Nasi Daging Semur + Wortel Bening",
                "description" =>
                    "Daging semur kecap spesial dengan wortel bening",
                "calories" => 560,
                "price" => 28000,
            ],

            // Vendor 2 Menus
            [
                "vendor_id" => $vendor2->id ?? $vendor1->id,
                "name" => "Nasi Ikan Lele + Tumis Kangkung",
                "description" =>
                    "Ikan lele goreng crispy dengan tumis kangkung saos tiram",
                "calories" => 510,
                "price" => 22000,
            ],
            [
                "vendor_id" => $vendor2->id ?? $vendor1->id,
                "name" => "Nasi Soto Ayam + Perkedel",
                "description" =>
                    "Soto ayam jawa dengan kuah kaldu rempah dan perkedel kentang",
                "calories" => 490,
                "price" => 22000,
            ],

            // Vendor 3 Menus
            [
                "vendor_id" => $vendor3->id ?? $vendor1->id,
                "name" => "Nasi Pecel Ayam + Urap Sayuran",
                "description" =>
                    "Ayam goreng dengan pecel bumbu kacang dan urap sayuran",
                "calories" => 515,
                "price" => 23000,
            ],
            [
                "vendor_id" => $vendor3->id ?? $vendor1->id,
                "name" => "Nasi Ayam Suwir + Buncis Tumis",
                "description" =>
                    "Ayam suwir bumbu merah dengan buncis tumis bawang",
                "calories" => 495,
                "price" => 23000,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(["name" => $menu["name"]], $menu);
        }
    }
}
