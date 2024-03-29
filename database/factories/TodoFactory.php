<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween(startDate: '-1 day');
        return [
            'content' => fake()->text(20),
            'category_id' => Category::factory(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
