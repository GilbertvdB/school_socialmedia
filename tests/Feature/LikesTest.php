<?php

use App\Models\User;
use App\Models\Post;
use App\View\Components\LikeButton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

beforeEach(function () {
    $this->post = Post::factory()->create();
    $this->user = User::factory()->create();
});

it('correctly updates the counter in database', function () {
    $post = $this->post;
    $like_count = $post->like_count;

    $component = new LikeButton($post);

    // increment the like counter
    $component->incrementLike();
    $post->refresh();
    expect($post->like_count)->toBeGreaterThan($like_count);

    // decrement the like counter
    $like_count = $post->like_count;

    $component->decrementLike();
    $post->refresh();
    expect($post->like_count)->toBeLessThan($like_count);

});

it('correctly toggles the like status', function () {
    $post = $this->post;
    $user = $this->user;

    //assert post is not init likeed
    expect($post->likes()->where('user_id', $user->id)->exists())->toBeFalse();

    $this->actingAs($user);

    //assert like toggle
    $response = $this->post(route('posts.toggle-like', $post));
    $response->assertJson(['liked' => true ] );
    expect($post->likes()->where('user_id', $user->id)->exists())->toBeTrue();

    // assert unlike toggle
    $response = $this->post(route('posts.toggle-like', $post));
    $response->assertJson(['liked' => false ] );
    expect($post->likes()->where('user_id', $user->id)->exists())->toBeFalse();

});

it('renders the correct commponent view for unliked status', function () {
    $post = $this->post;
    // for $liked in component class
    $user = $this->user;
    Auth::shouldReceive('id')->andReturn($user->id);

    $component = new LikeButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.like-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->liked)->toBeFalse();
    
    //assert the like icon is not filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="none"');

});

it('renders the correct commponent view for liked status', function () {
    $post = $this->post;
    $user = $this->user;
    
    $post->likes()->create(['user_id' => $user->id]);
    // for $likeed in component class
    Auth::shouldReceive('id')->andReturn($user->id);

    $component = new LikeButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.like-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->liked)->toBeTrue();
    
    //assert the like icon is filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="currentColor"');

});
