<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
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
            'id' => fake()->uuid(),
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'rating' => fake()->randomFloat(1, 2, 5),
            'comment' => fake()->realText(250),
            'created_at' => now(),
        ];
    }
}
