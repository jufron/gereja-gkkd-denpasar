<?php

namespace Database\Factories;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialAccount>
 */
class SocialAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $provider = fake()->randomElement(['google', 'facebook']);

        return [
            'user_id' => User::factory(),
            'provider' => $provider,
            'provider_id' => (string) fake()->randomNumber(9),
            'avatar' => null,
        ];
    }

    /**
     * Link the account to a Google login.
     */
    public function google(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'google',
            'provider_id' => fake()->numerify('##################'),
            'avatar' => 'https://i.pravatar.cc/150?u='.fake()->uuid(),
        ]);
    }

    /**
     * Link the account to a Facebook login.
     */
    public function facebook(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'facebook',
            'provider_id' => (string) fake()->numberBetween(10_000_000_000, 99_999_999_999),
            'avatar' => 'https://i.pravatar.cc/150?u='.fake()->uuid(),
        ]);
    }
}
