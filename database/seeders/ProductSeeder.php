<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Çorbalar (category_id: 1)
            [
                'product_name' => 'Mercimek Çorbası',
                'product_description' => 'Geleneksel Türk mutfağının vazgeçilmez lezzeti',
                'product_price' => 25.00,
                'category_id' => 1,
                'stock' => 100,
                'product_point' => 4.8,
                'product_image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400',
            ],
            [
                'product_name' => 'Ezogelin Çorbası',
                'product_description' => 'Baharatlı ve doyurucu',
                'product_price' => 28.00,
                'category_id' => 1,
                'stock' => 100,
                'product_point' => 4.7,
                'product_image' => 'https://images.unsplash.com/photo-1603105037880-880cd4edfb0d?w=400',
            ],
            // Ana Yemekler (category_id: 2)
            [
                'product_name' => 'Kuru Fasulye',
                'product_description' => 'Pilav ile servis edilir',
                'product_price' => 55.00,
                'category_id' => 2,
                'stock' => 50,
                'product_point' => 4.9,
                'product_image' => 'https://images.unsplash.com/photo-1626200419199-391ae4be7a41?w=400',
            ],
            [
                'product_name' => 'Karnıyarık',
                'product_description' => 'Patlıcan dolması, pilav ile',
                'product_price' => 65.00,
                'category_id' => 2,
                'stock' => 50,
                'product_point' => 4.8,
                'product_image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=400',
            ],
            // Pideler (category_id: 3)
            [
                'product_name' => 'Kuşbaşılı Pide',
                'product_description' => 'Fırında pişmiş, dana kuşbaşı ile',
                'product_price' => 75.00,
                'category_id' => 3,
                'stock' => 30,
                'product_point' => 4.9,
                'product_image' => 'https://images.unsplash.com/photo-1600628421055-4d30de868b8f?w=400',
            ],
            [
                'product_name' => 'Kaşarlı Pide',
                'product_description' => 'Bol kaşar peynirli',
                'product_price' => 60.00,
                'category_id' => 3,
                'stock' => 30,
                'product_point' => 4.7,
                'product_image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400',
            ],
            // İçecekler (category_id: 4)
            [
                'product_name' => 'Ayran',
                'product_description' => 'Ev yapımı ayran 300ml',
                'product_price' => 10.00,
                'category_id' => 4,
                'stock' => 200,
                'product_point' => 4.5,
                'product_image' => 'https://images.unsplash.com/photo-1543253687-c931c8e01820?w=400',
            ],
            [
                'product_name' => 'Kola',
                'product_description' => 'Soğuk servis 330ml',
                'product_price' => 15.00,
                'category_id' => 4,
                'stock' => 200,
                'product_point' => 4.3,
                'product_image' => 'https://images.unsplash.com/photo-1629203851122-3726ecdf080e?w=400',
            ],
            // Tatlılar (category_id: 5)
            [
                'product_name' => 'Sütlaç',
                'product_description' => 'Fırında pişmiş sütlaç',
                'product_price' => 35.00,
                'category_id' => 5,
                'stock' => 40,
                'product_point' => 4.8,
                'product_image' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400',
            ],
            [
                'product_name' => 'Künefe',
                'product_description' => 'Antep fıstıklı künefe',
                'product_price' => 55.00,
                'category_id' => 5,
                'stock' => 30,
                'product_point' => 4.9,
                'product_image' => 'https://images.unsplash.com/photo-1511911063855-2bf39afa5b2e?w=400',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
