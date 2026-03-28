<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Cervezas', 'description' => 'Cervezas de barril y botella', 'color' => '#F59E0B'],
            ['name' => 'Vinos', 'description' => 'Vinos tintos, blancos y rosados', 'color' => '#7C3AED'],
            ['name' => 'Licores', 'description' => 'Destilados y licores premium', 'color' => '#DC2626'],
            ['name' => 'Refrescos', 'description' => 'Bebidas sin alcohol', 'color' => '#2563EB'],
            ['name' => 'Cafetería', 'description' => 'Café, infusiones y acompañamientos', 'color' => '#92400E'],
            ['name' => 'Otros', 'description' => 'Productos varios', 'color' => '#6B7280'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
