<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                "vendor_id" => 1,
                "name" => "Nasi Ayam Bakar + Sayur Sup",
                "description" =>
                    "Ayam bakar dengan bumbu kecap manis, disajikan dengan sup sayuran segar",
                "calories" => 520,
                "price" => 25000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Telur Dadar + Capcay",
                "description" =>
                    "Telur dadar tebal dengan sayuran capcay tumis",
                "calories" => 480,
                "price" => 20000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Ikan Lele + Tumis Kangkung",
                "description" =>
                    "Ikan lele goreng crispy dengan tumis kangkung saos tiram",
                "calories" => 510,
                "price" => 22000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Tempe Goreng + Sayur Asem",
                "description" =>
                    "Tempe goreng tepung dengan sayur asem jakarta",
                "calories" => 450,
                "price" => 18000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Ayam Suwir + Buncis Tumis",
                "description" =>
                    "Ayam suwir bumbu merah dengan buncis tumis bawang",
                "calories" => 495,
                "price" => 23000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Ikan Patin + Daun Singkong",
                "description" =>
                    "Ikan patin panggang dengan rebusan daun singkong",
                "calories" => 505,
                "price" => 24000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Daging Semur + Wortel Bening",
                "description" =>
                    "Daging semur kecap spesial dengan wortel bening",
                "calories" => 560,
                "price" => 28000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Tahu Goreng + Sup Jagung",
                "description" => "Tahu goreng filled dengan sup jagung manis",
                "calories" => 430,
                "price" => 19000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Pecel Ayam + Urap Sayuran",
                "description" =>
                    "Ayam goreng dengan pecel bumbu kacang dan urap sayuran",
                "calories" => 515,
                "price" => 23000,
            ],
            [
                "vendor_id" => 1,
                "name" => "Nasi Soto Ayam + Perkedel",
                "description" =>
                    "Soto ayam jawa dengan kuah kaldu rempah dan perkedel kentang",
                "calories" => 490,
                "price" => 22000,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(
                ["name" => $menu["name"]],
                $menu
            );
        }
    }
}