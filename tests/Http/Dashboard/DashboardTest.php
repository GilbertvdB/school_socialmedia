<?php

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\ViewErrorBag;

uses()->group('home');

it('displays no items available when there are no posts', function () {
    $user = User::factory()->create();
    $posts = collect();

    $response = $this->actingAs($user)->view('dashboard', compact('posts'));

    $response->assertSee('No items available.')
             ->assertDontSee('@include(\'posts.post-box\', [\'post\' => $post])');
});

it('displays posts when the feed has a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $errors = new ViewErrorBag;

    $response = $this->actingAs($user)->view('dashboard', ['posts' => collect([$post]), 'errors' => $errors]);

    $response->assertDontSee('No items available.')
             ->assertSee($post->title);
});


it('shows the profile button', function () {
    $user = User::factory()->create();
    $posts = collect();

    $response = $this->actingAs($user)->view('dashboard', compact('posts'));
    $response->assertSee('Profile');
});

it('shows the logout button', function () {
    $user = User::factory()->create();
    $posts = collect();
    
    $response = $this->actingAs($user)->view('dashboard', compact('posts'));
    $response->assertSee('Log Out');
});