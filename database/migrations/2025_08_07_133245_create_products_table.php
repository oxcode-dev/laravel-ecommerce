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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('user_id')->nullable();
            $table->json('categories')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('hidden')->default(true);
            $table->json('images')->nullable();
            $table->string('status')->default('pending');
            $table->text('reason_for_rejection')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('last_approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
