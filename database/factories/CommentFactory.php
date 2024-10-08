<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $post = Post::factory()->create();
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'message' => "Here is a test comment with a message.",
        ];
    }
}
