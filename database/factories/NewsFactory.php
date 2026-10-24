<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'news_category_id' => NewsCategory::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'title' => $this->faker->sentence(6),
            'slug' => Str::slug($this->faker->sentence(6)),
            'excerpt' => $this->faker->sentence(20),
            'content' => $this->faker->paragraphs(5, true),
            'featured_image' => null,
            'status' => 'published',
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
