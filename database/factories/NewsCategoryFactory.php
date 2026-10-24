<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<NewsCategory>
 */
class NewsCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'color' => fake()->randomElement([
                'bg-accent/10 text-accent dark:text-accent-soft',
                'bg-blue-500/10 text-blue-600 dark:text-blue-400',
                'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
                'bg-rose-500/10 text-rose-600 dark:text-rose-400',
                'bg-amber-500/10 text-amber-600 dark:text-amber-400',
            ]),
            'description' => fake()->sentence(10),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }
}
