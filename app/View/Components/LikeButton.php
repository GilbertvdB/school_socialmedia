<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class LikeButton extends Component
{
    public $post;
    public $liked;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->liked = $post->likes->contains('user_id', Auth::id());
    }

    /**
     * Handles the toggle of the like botton.
     */
    public function toggleLike(Post $post)
    {   
        $this->post = $post;
        $user = Auth::user();
        $like = $this->post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $this->post->decrement('like_count');
            $this->liked = false;
        } else {
            $this->post->likes()->create(['user_id' => $user->id]);
            $this->post->increment('like_count');
            $this->liked = true;
        }

        return response()->json(['liked' => $this->liked, 'like_count' => $this->post->like_count]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.like-button');
    }
}
