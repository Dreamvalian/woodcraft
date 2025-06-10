<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop unused tables
        Schema::dropIfExists('categories');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('wishlists');

        // If shops table doesn't exist, rename products to shops
        if (!Schema::hasTable('shops') && Schema::hasTable('products')) {
            Schema::rename('products', 'shops');
        }

        // Update foreign key references
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->renameColumn('product_id', 'shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->renameColumn('product_id', 'shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Recreate dropped tables
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('amount', 8, 2);
            $table->enum('type', ['percentage', 'fixed']);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Revert foreign key changes
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->renameColumn('shop_id', 'product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->renameColumn('shop_id', 'product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // If products table doesn't exist, rename shops to products
        if (!Schema::hasTable('products') && Schema::hasTable('shops')) {
            Schema::rename('shops', 'products');
        }
    }
}; 