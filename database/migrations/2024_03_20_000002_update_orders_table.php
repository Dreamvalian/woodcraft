<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->unique()->after('id');
            $table->foreignId('shipping_address_id')->nullable()->after('user_id')->constrained('addresses');
            $table->foreignId('billing_address_id')->nullable()->after('shipping_address_id')->constrained('addresses');
            $table->string('payment_method')->after('payment_status');
            $table->string('payment_transaction_id')->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_transaction_id');
            $table->string('shipping_method')->after('shipping_cost');
            $table->text('notes')->nullable()->after('shipping_method');
            $table->timestamp('placed_at')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id']);
            $table->dropForeign(['billing_address_id']);
            $table->dropColumn([
                'order_number',
                'shipping_address_id',
                'billing_address_id',
                'payment_method',
                'payment_transaction_id',
                'paid_at',
                'shipping_method',
                'notes',
                'placed_at'
            ]);
        });
    }
}; 