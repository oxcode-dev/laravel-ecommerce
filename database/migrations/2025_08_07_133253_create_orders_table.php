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
            $table->timestamps();
        });

//         id INT PRIMARY KEY AUTO_INCREMENT,
//   user_id INT,
//   address_id INT,
//   total_amount DECIMAL(10,2),
//   status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled'),
//   payment_method VARCHAR(50),
//   payment_status ENUM('unpaid', 'paid', 'refunded'),
//   created_at TIMESTAMP,
//   updated_at TIMESTAMP,
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
