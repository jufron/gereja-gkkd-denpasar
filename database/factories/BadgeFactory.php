<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Badge>
 */
class BadgeFactory extends Factory
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
                'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
                'bg-blue-500/10 text-blue-600 dark:text-blue-400',
                'bg-rose-500/10 text-rose-600 dark:text-rose-400',
            ]),
        ];
    }
}
