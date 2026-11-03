<?php

namespace Database\Factories;

use App\Models\HeroBanner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroBanner>
 */
class HeroBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'badge' => ucfirst(fake()->words(2, true)),
            'caption' => fake()->sentence(6),
            'alt' => fake()->sentence(4),
            'link_url' => null,
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
