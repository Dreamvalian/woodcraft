<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Handcrafted Oak Dining Table',
                'description' => 'Beautiful handcrafted oak dining table with traditional joinery. Perfect for family gatherings.',
                'price' => 1299.99,
                'stock' => 5,
                'image_url' => 'products/oak-dining-table.jpg',
            ],
            [
                'name' => 'Wooden Wall Clock',
                'description' => 'Elegant wooden wall clock with hand-carved details. Battery operated.',
                'price' => 89.99,
                'stock' => 15,
                'image_url' => 'products/wooden-wall-clock.jpg',
            ],
            [
                'name' => 'Bamboo Cutting Board',
                'description' => 'Eco-friendly bamboo cutting board with juice groove. Perfect for kitchen use.',
                'price' => 29.99,
                'stock' => 30,
                'image_url' => 'products/bamboo-cutting-board.jpg',
            ],
            [
                'name' => 'Wooden Planter Box',
                'description' => 'Handcrafted wooden planter box for indoor plants. Includes drainage holes.',
                'price' => 49.99,
                'stock' => 20,
                'image_url' => 'products/wooden-planter.jpg',
            ],
            [
                'name' => 'Teak Garden Bench',
                'description' => 'Weather-resistant teak garden bench. Perfect for outdoor spaces.',
                'price' => 299.99,
                'stock' => 8,
                'image_url' => 'products/teak-bench.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'min_order_quantity' => 1,
                'max_order_quantity' => 5,
                'image_url' => $product['image_url'],
                'is_active' => true,
            ]);
        }
    }
} 