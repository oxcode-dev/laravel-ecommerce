<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'user_id' => User::factory(),
            'street' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->city(),
            // 'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'is_default' => fake()->boolean(10),
        ];
    }
}