<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Çorbalar', 'category_order' => 1],
            ['category_name' => 'Ana Yemekler', 'category_order' => 2],
            ['category_name' => 'Pideler', 'category_order' => 3],
            ['category_name' => 'İçecekler', 'category_order' => 4],
            ['category_name' => 'Tatlılar', 'category_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
