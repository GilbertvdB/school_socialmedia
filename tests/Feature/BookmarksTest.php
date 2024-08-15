<?php

use App\Models\Bookmark;
use App\Models\User;
use App\Models\Post;
use App\View\Components\BookmarkButton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ViewErrorBag;

uses()->group('bookmarks');

beforeEach(function () {
    $this->post = Post::factory()->create();
    $this->user = User::factory()->create();
});

test('bookmark route redirects unauth user to the login page', function () {
    $response = $this->get('/bookmarks');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('bookmark route returns a succesfull response for Auth user', function () {
    $this->actingAs($this->user);
    $response = $this->get('/bookmarks');
    $response->assertStatus(200);
});

test('bookmark page displays no bookmarks available message', function () {
    $bookmarks = collect();

    $response = $this->actingAs($this->user)->view('posts.bookmarks', compact('bookmarks'));

    $response->assertSee('No bookmarks available.')
             ->assertDontSee('@include(\'posts.post-box\', [\'post\' => $bookmark->post])');
});

test('bookmark page displays bookmarks in the feed when bookmarks are available', function () {
    $post = $this->post;
    $post->bookmarks()->create(['user_id' => $this->user->id]);
    $bookmarks = Bookmark::where('user_id', $this->user->id)->paginate(5);
    $errors = new ViewErrorBag;

    expect($post->bookmarks()->where('user_id', $this->user->id)->exists())->toBeTrue();
    $response = $this->actingAs($this->user)->view('posts.bookmarks', compact('bookmarks', 'errors'));;

    $response->assertDontSee('No bookmarks available.')
             ->assertSee($post->title);
});

it('correctly toggles the bookmark status', function () {
    $post = $this->post;
    $user = $this->user;

    //assert post is not init bookmarked
    expect($post->bookmarks()->where('user_id', $user->id)->exists())->toBeFalse();

    $this->actingAs($user);

    //assert bookmark toggle
    $response = $this->post(route('posts.toggle-bookmark', $post));
    $response->assertOk();
    $response->assertJson(['bookmarked' => true ] );
    expect($post->bookmarks()->where('user_id', $user->id)->exists())->toBeTrue();

    // assert unbookmark toggle
    $response = $this->post(route('posts.toggle-bookmark', $post));
    $response->assertOk();
    $response->assertJson(['bookmarked' => false ] );
    expect($post->bookmarks()->where('user_id', $user->id)->exists())->toBeFalse();

});

it('renders the correct commponent view for unbookmarked status', function () {
    $post = $this->post;
    // for $bookmarked in component class
    $user = $this->user;
    Auth::shouldReceive('id')->andReturn($user->id);

    $component = new BookmarkButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.bookmark-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->bookmarked)->toBeFalse();
    
    //assert the bookmark icon is not filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="none"');

});

it('renders the correct commponent view for bookmarked status', function () {
    $post = $this->post;
    $user = $this->user;
    
    $post->bookmarks()->create(['user_id' => $user->id]);
    // for $bookmarked in component class
    Auth::shouldReceive('id')->andReturn($user->id);

    $component = new BookmarkButton($post);
    $view = $component->render();
    
    expect($view->name())->toBe('components.bookmark-button');
    expect($component->post->id)->toBe($post->id);
    expect($component->bookmarked)->toBeTrue();
    
    //assert the bookmark icon is filled
    $rendered = Blade::renderComponent($component);
    expect($rendered)->toContain('fill="currentColor"');

});
