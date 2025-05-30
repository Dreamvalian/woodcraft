<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Classic Wooden Chair',
                'description' => 'Handcrafted wooden chair made from premium teak wood. Features elegant carvings and comfortable design.',
                'price' => 1250000,
                'stock' => 10,
                'image' => 'products/chair-1.jpg',
                'model' => 'CH-001',
                'category' => 'Furniture',
                'features' => [
                    'Premium teak wood',
                    'Hand-carved details',
                    'Ergonomic design',
                    'Durable finish'
                ]
            ],
            [
                'name' => 'Modern Coffee Table',
                'description' => 'Contemporary coffee table with a minimalist design. Perfect for modern living spaces.',
                'price' => 2500000,
                'stock' => 8,
                'image' => 'products/table-1.jpg',
                'model' => 'CT-001',
                'category' => 'Furniture',
                'features' => [
                    'Solid mahogany wood',
                    'Tempered glass top',
                    'Modern design',
                    'Easy assembly'
                ]
            ],
            [
                'name' => 'Wooden Wall Shelf',
                'description' => 'Decorative wall shelf with multiple compartments. Great for displaying books and decorative items.',
                'price' => 750000,
                'stock' => 15,
                'image' => 'products/shelf-1.jpg',
                'model' => 'WS-001',
                'category' => 'Storage',
                'features' => [
                    'Oak wood construction',
                    'Multiple compartments',
                    'Wall-mounted design',
                    'Natural finish'
                ]
            ],
            [
                'name' => 'Wooden Picture Frame',
                'description' => 'Handcrafted wooden picture frame with intricate details. Perfect for your cherished memories.',
                'price' => 350000,
                'stock' => 20,
                'image' => 'products/frame-1.jpg',
                'model' => 'PF-001',
                'category' => 'Decor',
                'features' => [
                    'Premium pine wood',
                    'Hand-carved details',
                    'Glass protection',
                    'Multiple sizes available'
                ]
            ],
            [
                'name' => 'Wooden Jewelry Box',
                'description' => 'Elegant jewelry box with multiple compartments and velvet lining. Perfect for organizing your precious accessories.',
                'price' => 850000,
                'stock' => 12,
                'image' => 'products/jewelry-box-1.jpg',
                'model' => 'JB-001',
                'category' => 'Storage',
                'features' => [
                    'Solid walnut wood',
                    'Velvet lining',
                    'Multiple compartments',
                    'Lock mechanism'
                ]
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 