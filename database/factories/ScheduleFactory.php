<?php

namespace Database\Factories;

use App\Models\Badge;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'badge_id' => Badge::factory(),
            'title' => fake()->sentence(2, false),
            'time' => 'Pukul '.fake()->time('H.i').' WITA',
            'day' => fake()->randomElement(['Minggu', 'Senin', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']),
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
