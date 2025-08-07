<?php

namespace Database\Factories;

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
            "user_id" => User::factory(),
            "categories" => [
               [
                   "id" => 1,
                  "url" => "dry-food",
                  "name" => "Dry Food",
                  "parentCategory" => 0
               ],
               [
                   "id" => 3,
                  "url" => "fabrics",
                  "name" => "Fabrics",
                  "parentCategory" => 0
               ]
            ],
            "type" => "physical",
            "title" =>  $title = $this->faker->realText(random_int(10,20)) .  ' ' . Str::random(3),
            "description" => $this->faker->realText(),
            "url" => Str::slug($title),
            "hidden" => true,
            "images" => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl()
            ],
            "status" => "pending",
            "approved_at" => null,
            "last_approved_at" => null,
        ];
    }
}
