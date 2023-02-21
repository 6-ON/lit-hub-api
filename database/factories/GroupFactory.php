<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
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
            'label'=>fake()->name,
            'slug'=>$slug,
            'image'=>fake()->imageUrl(word: $slug),
            'description'=>fake()->text,
            'user_id'=>User::factory(),
        ];
    }
}
