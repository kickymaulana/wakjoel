<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['nama_item' => 'Nasi Putih', 'harga' => 5000, 'is_available' => true],
            ['nama_item' => 'Rendang Daging', 'harga' => 18000, 'is_available' => true],
            ['nama_item' => 'Ayam Pop', 'harga' => 17000, 'is_available' => true],
            ['nama_item' => 'Ayam Bakar', 'harga' => 17000, 'is_available' => true],
            ['nama_item' => 'Telur Dadar', 'harga' => 7000, 'is_available' => true],
            ['nama_item' => 'Bakwan / Perkedel', 'harga' => 2000, 'is_available' => true],
            ['nama_item' => 'Kerupuk Jengkol', 'harga' => 3000, 'is_available' => true],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
