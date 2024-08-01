<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CommentButton extends Component
{
    public $post;
    public $commented;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        // $this->commented = $post->comments->contains('user_id', Auth::id());
        $this->commented = false;
    }

    /**
     * Handles the toggle of the like botton.
     */
    public function toggleComment(Post $post)
    {   
        $this->post = $post;
        $user = Auth::user();
        $comment = $this->post->coments()->where('user_id', $user->id)->first();

        if ($comment) {
            $comment->delete();
            $this->post->decrement('comment_count');
            $this->commented = false;
        } else {
            $this->post->comments()->create(['user_id' => $user->id]);
            $this->post->increment('comment_count');
            $this->commented = true;
        }

        return response()->json(['commented' => $this->commented, 'comment_count' => $this->post->comment_count]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment-button');
    }
}
