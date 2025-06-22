<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('order_number')->unique();
      $table->string('status')->default('pending');
      $table->decimal('total', 10, 2);
      $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null');
      $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->onDelete('set null');
      $table->string('payment_method')->nullable();
      $table->string('payment_status')->default('pending');
      $table->string('shipping_method')->nullable();
      $table->decimal('shipping_cost', 10, 2)->default(0);
      $table->text('notes')->nullable();
      $table->timestamp('placed_at')->nullable();
      $table->timestamp('paid_at')->nullable();
      $table->string('payment_transaction_id')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('orders');
  }
};