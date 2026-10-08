<?php

namespace Database\Factories;

use App\Models\AppSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AppSetting>
 */
class AppSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = fake()->unique()->slug(2, false);

        return [
            'group' => fake()->randomElement(['general', 'contact', 'donation', 'social', 'seo']),
            'key' => $key,
            'value' => fake()->word(),
            'type' => 'string',
            'description' => fake()->sentence(),
            'is_public' => false,
        ];
    }
}
