<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $categories = [
        'clothings', 'phones & tablets', 'gaming',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $category = fake()->randomElement($this->categories),
            'slug' => Str::slug($category) . '-' . strtotime(now()),
            'description' => fake()->realText(200, 2),
        ];
    }
}
