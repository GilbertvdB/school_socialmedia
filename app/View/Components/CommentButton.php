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
    public $userCommentsCount;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->commented = $post->comments->contains('user_id', Auth::id());
        $this->userCommentsCount = $this->getUserCommentsCount();
    }

    /**
     * Handles the toggle of the like botton.
     */
    public function toggleComment(Post $post)
    {   
        $this->post = $post;
        $user = Auth::user();
        $this->userCommentsCount = $this->getUserCommentsCount();
        $comment = $this->post->comments()->whereBelongsTo($user)->first();

        if ($comment) {
            $comment->delete();
            $this->decrementComment();
            $this->commented = false;
        } else {
            $this->post->comments()->create(['user_id' => $user->id]);
            $this->incrementComment();
            $this->commented = true;
        }
    }

    /**
     * Decrement the comment count for the post with 1.
     */
    public function decrementComment()
    {   
        if($this->post->comment_count > 0)
        {
            $this->post->decrement('comment_count');
        }
    }

    /**
     * Increment the comment count for the post with 1.
     */
    public function incrementComment()
    {
        $this->post->increment('comment_count');
    }

    /**
     * Get the ammount of comments of a user for the given post.
     */
    public function getUserCommentsCount()
    {
        $user = Auth::user();
        $comments = $user->comments->where('post_id', $this->post->id);
        
        return count($comments);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment-button');
    }
}
