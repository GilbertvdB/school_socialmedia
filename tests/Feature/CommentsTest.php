<?php

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\View\Components\CommentButton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

beforeEach(function () {
    $this->post = Post::factory()->create();
    $this->user = User::factory()->create();
});

it('correctly updates the counter in database', function () {
    $post = $this->post;
    $comment_count = $post->comment_count;

    Auth::shouldReceive('user')->andReturn($this->user);
    Auth::shouldReceive('id')->andReturn($this->user->id);
    $component = new CommentButton($post);

    // increment the comment counter
    $component->incrementComment();
    $post->refresh();
    expect($post->comment_count)->toBeGreaterThan($comment_count);

    // decrement the comment counter
    $comment_count = $post->comment_count;

    $component->decrementComment();
    $post->refresh();
    expect($post->comment_count)->toBeLessThan($comment_count);

});

it('correctly has comments/ has no comments', function () {
    $post = $this->post;
    $user = $this->user;

    //assert post is not init commented
    expect($post->comments()->where('user_id', $user->id)->exists())->toBeFalse();

    //assert had comments
    $comment = Comment::create(['user_id' => $user->id,
                                'post_id' => $post->id,
                                'message' => 'My first commment message',]);
    expect($post->comments()->where('user_id', $user->id)->exists())->toBeTrue();

    // assert has no comments
    $comment->delete(); 
    expect($post->comments()->where('user_id', $user->id)->exists())->toBeFalse();

});

it('renders the correct commponent view for uncommented status', function () {
    $post = $this->post;
    // for $commented in component class
    $user = $this->user;
    Auth::shouldReceive('id')->andReturn($user->id);
    Auth::shouldReceive('user')->andReturn($this->user);
    $component = new CommentButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.comment-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->commented)->toBeFalse();
    
    //assert the comment icon is not filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="none"');

});

it('renders the correct commponent view for commented status', function () {
    $post = $this->post;
    $user = $this->user;
    
    $post->comments()->create(['user_id' => $user->id, 'message' => "helo, This is a message."]);
    // for $commented in component class
    Auth::shouldReceive('id')->andReturn($user->id);
    Auth::shouldReceive('user')->andReturn($this->user);

    $component = new CommentButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.comment-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->commented)->toBeTrue();
    
    //assert the comment icon is filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="currentColor"');

});