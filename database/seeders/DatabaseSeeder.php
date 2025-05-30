<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@woodcraft.com',
            'phone' => '1234567890',
            'address' => '123 Admin St, Admin City',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'username' => 'john',
                'email' => 'john@example.com',
                'phone' => '2345678901',
                'address' => '456 Main St, City',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'jane',
                'email' => 'jane@example.com',
                'phone' => '3456789012',
                'address' => '789 Oak St, Town',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }

        // Create categories
        $categories = [
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'Handcrafted wooden furniture pieces',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Decorations',
                'slug' => 'decorations',
                'description' => 'Wooden decorative items for your home',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Tables',
                'slug' => 'tables',
                'description' => 'Dining tables, coffee tables, and more',
                'is_active' => true,
                'parent_id' => 1,
            ],
            [
                'name' => 'Chairs',
                'slug' => 'chairs',
                'description' => 'Dining chairs, accent chairs, and stools',
                'is_active' => true,
                'parent_id' => 1,
            ],
            [
                'name' => 'Wall Art',
                'slug' => 'wall-art',
                'description' => 'Wooden wall decorations and art pieces',
                'is_active' => true,
                'parent_id' => 2,
            ],
            [
                'name' => 'Kitchen Items',
                'slug' => 'kitchen-items',
                'description' => 'Wooden kitchen accessories and utensils',
                'is_active' => true,
                'parent_id' => 2,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }

        // Create products
        $products = [
            [
                'name' => 'Oak Dining Table',
                'slug' => 'oak-dining-table',
                'description' => 'Beautiful handcrafted oak dining table with a modern design. Perfect for family gatherings.',
                'price' => 599.99,
                'sale_price' => 499.99,
                'stock' => 10,
                'sku' => 'TBL-001',
                'category_id' => 3,
                'features' => json_encode([
                    'color' => 'natural',
                    'style' => 'modern',
                    'material' => 'solid oak',
                    'finish' => 'natural oil',
                    'assembly' => 'required'
                ]),
                'is_active' => true,
                'weight' => 45.5,
                'dimensions' => '180x90x75',
                'material' => 'Oak',
                'min_order_quantity' => 1,
                'max_order_quantity' => 5,
            ],
            [
                'name' => 'Mahogany Dining Chair',
                'slug' => 'mahogany-dining-chair',
                'description' => 'Elegant mahogany dining chair with comfortable cushion. Pairs perfectly with our dining tables.',
                'price' => 199.99,
                'sale_price' => null,
                'stock' => 20,
                'sku' => 'CHR-001',
                'category_id' => 4,
                'features' => json_encode([
                    'color' => 'dark',
                    'style' => 'classic',
                    'material' => 'mahogany',
                    'finish' => 'lacquer',
                    'assembly' => 'minimal'
                ]),
                'is_active' => true,
                'weight' => 15.2,
                'dimensions' => '45x45x90',
                'material' => 'Mahogany',
                'min_order_quantity' => 2,
                'max_order_quantity' => 8,
            ],
            [
                'name' => 'Wooden Wall Clock',
                'slug' => 'wooden-wall-clock',
                'description' => 'Handcrafted wooden wall clock with a rustic design. Adds warmth to any room.',
                'price' => 89.99,
                'sale_price' => 69.99,
                'stock' => 15,
                'sku' => 'DEC-001',
                'category_id' => 5,
                'features' => json_encode([
                    'color' => 'natural',
                    'style' => 'rustic',
                    'material' => 'pine',
                    'finish' => 'wax',
                    'assembly' => 'none'
                ]),
                'is_active' => true,
                'weight' => 2.5,
                'dimensions' => '30x30x5',
                'material' => 'Pine',
                'min_order_quantity' => 1,
                'max_order_quantity' => 10,
            ],
            [
                'name' => 'Wooden Cutting Board',
                'slug' => 'wooden-cutting-board',
                'description' => 'Premium wooden cutting board made from sustainable bamboo. Perfect for kitchen use.',
                'price' => 39.99,
                'sale_price' => null,
                'stock' => 30,
                'sku' => 'KIT-001',
                'category_id' => 6,
                'features' => json_encode([
                    'color' => 'natural',
                    'style' => 'modern',
                    'material' => 'bamboo',
                    'finish' => 'food-safe oil',
                    'assembly' => 'none'
                ]),
                'is_active' => true,
                'weight' => 1.2,
                'dimensions' => '40x25x2',
                'material' => 'Bamboo',
                'min_order_quantity' => 1,
                'max_order_quantity' => 20,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }

        // Create product images
        $productImages = [
            [
                'product_id' => 1,
                'image_path' => '/images/products/oak-table-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Oak Dining Table Front View',
            ],
            [
                'product_id' => 1,
                'image_path' => '/images/products/oak-table-2.jpg',
                'is_primary' => false,
                'alt_text' => 'Oak Dining Table Side View',
            ],
            [
                'product_id' => 2,
                'image_path' => '/images/products/mahogany-chair-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Mahogany Chair Front View',
            ],
            [
                'product_id' => 3,
                'image_path' => '/images/products/wall-clock-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Wooden Wall Clock',
            ],
            [
                'product_id' => 4,
                'image_path' => '/images/products/cutting-board-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Wooden Cutting Board',
            ],
        ];

        foreach ($productImages as $image) {
            \App\Models\ProductImage::create($image);
        }

        // Create reviews
        $reviews = [
            [
                'product_id' => 1,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Beautiful table! The quality is outstanding and it looks even better in person.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ],
            [
                'product_id' => 2,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Very comfortable chairs. The mahogany finish is perfect.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ],
            [
                'product_id' => 3,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Love this clock! It adds a nice rustic touch to our living room.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $review) {
            \App\Models\Review::create($review);
        }

        // Create orders
        $orders = [
            [
                'user_id' => 2,
                'order_number' => 'ORD-001',
                'total_amount' => 799.98,
                'status' => 'delivered',
                'shipping_address' => '456 Main St, City',
                'shipping_phone' => '2345678901',
                'shipping_name' => 'John Doe',
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'tracking_number' => 'TRK123456',
            ],
            [
                'user_id' => 3,
                'order_number' => 'ORD-002',
                'total_amount' => 89.99,
                'status' => 'processing',
                'shipping_address' => '789 Oak St, Town',
                'shipping_phone' => '3456789012',
                'shipping_name' => 'Jane Smith',
                'payment_method' => 'paypal',
                'payment_status' => 'paid',
            ],
        ];

        foreach ($orders as $order) {
            \App\Models\Order::create($order);
        }

        // Create order items
        $orderItems = [
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 599.99,
                'subtotal' => 599.99,
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 199.99,
                'subtotal' => 199.99,
            ],
            [
                'order_id' => 2,
                'product_id' => 3,
                'quantity' => 1,
                'price' => 89.99,
                'subtotal' => 89.99,
            ],
        ];

        foreach ($orderItems as $item) {
            \App\Models\OrderItem::create($item);
        }

        // Create product discounts
        $discounts = [
            [
                'product_id' => 1,
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'product_id' => 3,
                'discount_type' => 'fixed',
                'discount_value' => 20.00,
                'start_date' => now(),
                'end_date' => now()->addDays(15),
                'is_active' => true,
            ],
        ];

        foreach ($discounts as $discount) {
            \App\Models\ProductDiscount::create($discount);
        }

        // Add seasonal products
        $seasonalProducts = [
            [
                'name' => 'Christmas Wooden Ornament Set',
                'slug' => 'christmas-wooden-ornament-set',
                'description' => 'Handcrafted wooden Christmas ornaments featuring traditional holiday designs.',
                'price' => 49.99,
                'sale_price' => 39.99,
                'stock' => 50,
                'sku' => 'DEC-002',
                'category_id' => 2,
                'features' => json_encode([
                    'color' => 'natural',
                    'style' => 'traditional',
                    'material' => 'pine',
                    'finish' => 'natural oil',
                    'assembly' => 'none'
                ]),
                'is_active' => true,
                'weight' => 1.5,
                'dimensions' => '20x20x5',
                'material' => 'Pine',
                'min_order_quantity' => 1,
                'max_order_quantity' => 10,
            ],
            [
                'name' => 'Summer Picnic Table',
                'slug' => 'summer-picnic-table',
                'description' => 'Perfect outdoor wooden picnic table for summer gatherings.',
                'price' => 299.99,
                'sale_price' => 249.99,
                'stock' => 15,
                'sku' => 'TBL-002',
                'category_id' => 3,
                'features' => json_encode([
                    'color' => 'natural',
                    'style' => 'outdoor',
                    'material' => 'cedar',
                    'finish' => 'weather-resistant',
                    'assembly' => 'required'
                ]),
                'is_active' => true,
                'weight' => 35.0,
                'dimensions' => '180x60x75',
                'material' => 'Cedar',
                'min_order_quantity' => 1,
                'max_order_quantity' => 3,
            ],
        ];

        foreach ($seasonalProducts as $product) {
            \App\Models\Product::create($product);
        }

        // Add out-of-stock products
        $outOfStockProducts = [
            [
                'name' => 'Limited Edition Wooden Chess Set',
                'slug' => 'limited-edition-wooden-chess-set',
                'description' => 'Exquisite hand-carved wooden chess set with storage box.',
                'price' => 199.99,
                'sale_price' => null,
                'stock' => 0,
                'sku' => 'GAM-001',
                'category_id' => 2,
                'features' => json_encode([
                    'color' => 'dark',
                    'style' => 'luxury',
                    'material' => 'ebony and maple',
                    'finish' => 'polished',
                    'assembly' => 'none'
                ]),
                'is_active' => true,
                'weight' => 2.0,
                'dimensions' => '30x30x5',
                'material' => 'Ebony and Maple',
                'min_order_quantity' => 1,
                'max_order_quantity' => 1,
            ],
        ];

        foreach ($outOfStockProducts as $product) {
            \App\Models\Product::create($product);
        }

        // Add products with multiple images
        $multiImageProducts = [
            [
                'product_id' => 5, // Christmas Ornament Set
                'image_path' => '/images/products/christmas-ornaments-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Christmas Ornament Set Main View',
            ],
            [
                'product_id' => 5,
                'image_path' => '/images/products/christmas-ornaments-2.jpg',
                'is_primary' => false,
                'alt_text' => 'Christmas Ornament Set Detail View',
            ],
            [
                'product_id' => 5,
                'image_path' => '/images/products/christmas-ornaments-3.jpg',
                'is_primary' => false,
                'alt_text' => 'Christmas Ornament Set Packaging',
            ],
            [
                'product_id' => 6, // Summer Picnic Table
                'image_path' => '/images/products/picnic-table-1.jpg',
                'is_primary' => true,
                'alt_text' => 'Summer Picnic Table Main View',
            ],
            [
                'product_id' => 6,
                'image_path' => '/images/products/picnic-table-2.jpg',
                'is_primary' => false,
                'alt_text' => 'Summer Picnic Table Assembly View',
            ],
        ];

        foreach ($multiImageProducts as $image) {
            \App\Models\ProductImage::create($image);
        }

        // Add more reviews for product variety
        $additionalReviews = [
            [
                'product_id' => 5,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Beautiful ornaments! Perfect for our Christmas tree.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ],
            [
                'product_id' => 6,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Great picnic table, very sturdy and weather-resistant.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ],
        ];

        foreach ($additionalReviews as $review) {
            \App\Models\Review::create($review);
        }

        // Add more product discounts
        $additionalDiscounts = [
            [
                'product_id' => 5,
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'product_id' => 6,
                'discount_type' => 'fixed',
                'discount_value' => 50.00,
                'start_date' => now(),
                'end_date' => now()->addDays(45),
                'is_active' => true,
            ],
        ];

        foreach ($additionalDiscounts as $discount) {
            \App\Models\ProductDiscount::create($discount);
        }
    }
}
