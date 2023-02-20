<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = fake()->unique()->slug();
        return [
            'title'=>fake()->word,
            'slug'=>$slug,
            'description'=>fake()->sentence(),
            'image'=>fake()->imageUrl(word: $slug),
            'user_id'=>User::factory(),
            'category_id'=>Category::factory(),
            'attachment'=>fake()->url(),
        ];
    }
}
