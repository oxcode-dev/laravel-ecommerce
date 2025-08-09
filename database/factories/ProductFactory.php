<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => fake()->uuid,
            "user_id" => User::factory(),
            "category_id" => Category::factory(),
            "title" =>  $title = $this->faker->realText(random_int(10,20)),
            "summary" => $this->faker->realText(150),
            "description" => $this->faker->realText(),
            "slug" => Str::slug($title),
            "is_active" => fake()->boolean(45),
            "price" => fake()->randomFloat(2, 10, 1000),
            "image" => fake()->imageUrl(),
            'stock' => fake()->numberBetween(1, 100),
            // "status" => "pending",
        ];
    }
}
