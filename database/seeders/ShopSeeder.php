<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $shops = [
            [
                'name' => 'Classic Wooden Chair',
                'description' => 'Handcrafted wooden chair made from premium oak. Perfect for dining rooms and kitchens.',
                'price' => 199.99,
                'material' => 'Oak',
                'dimensions' => '45x45x85 cm',
                'weight' => 8.5,
                'stock' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Modern Coffee Table',
                'description' => 'Contemporary coffee table with a minimalist design. Made from sustainable teak wood.',
                'price' => 299.99,
                'material' => 'Teak',
                'dimensions' => '120x60x45 cm',
                'weight' => 25.0,
                'stock' => 10,
                'status' => 'active',
            ],
            [
                'name' => 'Rustic Bookshelf',
                'description' => 'Sturdy bookshelf with a rustic finish. Perfect for displaying books and decorative items.',
                'price' => 399.99,
                'material' => 'Pine',
                'dimensions' => '180x40x30 cm',
                'weight' => 35.0,
                'stock' => 8,
                'status' => 'active',
            ],
            [
                'name' => 'Wooden Bed Frame',
                'description' => 'Solid wood bed frame with a classic design. Includes headboard and footboard.',
                'price' => 599.99,
                'material' => 'Mahogany',
                'dimensions' => '200x180x45 cm',
                'weight' => 45.0,
                'stock' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($shops as $shop) {
            Shop::create([
                'name' => $shop['name'],
                'slug' => Str::slug($shop['name']),
                'description' => $shop['description'],
                'price' => $shop['price'],
                'material' => $shop['material'],
                'dimensions' => $shop['dimensions'],
                'weight' => $shop['weight'],
                'stock' => $shop['stock'],
                'status' => $shop['status'],
                'image' => 'shops/' . Str::slug($shop['name']) . '.jpg',
            ]);
        }
    }
} 