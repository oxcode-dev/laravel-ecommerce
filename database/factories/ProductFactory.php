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
            "store_product_id" => null,
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
            "variants" => [
               [
                   "sku" => $this->faker->isbn10,
                  "price" => $this->faker->randomElement(range(10.99, 199.99, 5.0)),
                  "options" => [
                       "L",
                       "Fabric"
                   ],
                  "sales_price" => null,
                  "available_stock" => random_int(1, 50)
               ],
               [
                   "sku" => $this->faker->isbn10,
                  "price" => $this->faker->randomElement(range(10.99, 199.99, 5.0)),
                      "options" => [
                       "L",
                       "Silk"
                   ],
                  "sales_price" => null,
                  "available_stock" => random_int(1, 50)
               ]
            ],
            "options" => [
               [
                   "name" => "Colour",
                  "values" => [
                       "White",
                       "Red"
                   ],
                  "advance" => false
               ],
               [
                   "name" => "Size",
                  "values" => [
                       "L",
                       "M",
                       "XL"
                   ],
                  "advance" => true
               ],
               [
                   "name" => "Design",
                  "values" => [
                       "Fabric",
                       "Silk"
                   ],
                  "advance" => true
               ]
            ],
            "changes" => null,
            "status" => "pending",
            "approved_at" => null,
            "last_approved_at" => null,
        ];
    }
}
