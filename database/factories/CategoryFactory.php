<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween(startDate: '-2 day', endDate: '-1 day');
        return [
            'name' => fake()->text(10),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
