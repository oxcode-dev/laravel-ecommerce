<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->foreignUuid('address_id');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('delivery_cost', 10, 2)->default(0.00);
            $table->enum('status',['pending', 'paid', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'bank transfer', 'online payment'])->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
