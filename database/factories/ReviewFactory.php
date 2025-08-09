<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            // $table->foreignUuid('product_id');
            // $table->foreignUuid('user_id');
            // $table->integer('rating')->default(1);
            // $table->text('comment');
            // $table->timestamp('created_at');
        ];
    }
}
