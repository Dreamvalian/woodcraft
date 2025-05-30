<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('created_at');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->index(['user_id', 'product_id']);
            $table->index('session_id');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'product_id']);
            $table->dropIndex(['session_id']);
        });
    }
}; 