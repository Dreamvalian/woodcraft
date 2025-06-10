<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameShopsTableToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shops') && !Schema::hasTable('products')) {
            Schema::rename('shops', 'products');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (!Schema::hasTable('shops') && Schema::hasTable('products')) {
            Schema::rename('products', 'shops');
        }
    }
}
