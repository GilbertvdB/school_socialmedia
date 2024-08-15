<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $user = User::factory()->create();
        return [
            'title' => "Fake Title",
            'body' => fake()->realText($maxNbChars = 200, $indexSize = 2),
            'author_id' => $user->id,
            'like_count' => 0,
            'comment_count' => 0,
        ];
    }
}
