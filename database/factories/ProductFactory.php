<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => fake()->unique()->name(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => fake()->text(),
            'image' => fake()->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg'),
            'price' => fake()->numberBetween($min = 10, $max = 100)
        ];
    }
}
