<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class BookmarkButton extends Component
{
    public $post;
    public $bookmarked;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->bookmarked = $post->bookmarks->contains('user_id', Auth::id());
    }

    /**
     * Handles the toggle of the bookmark botton.
     */
    public function toggleBookmark(Post $post)
    {   
        $this->post = $post;
        $user = Auth::user();
        $bookmark = $this->post->bookmarks()->where('user_id', $user->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $this->bookmarked = false;
        } else {
            $this->post->bookmarks()->create(['user_id' => $user->id]);
            $this->bookmarked = true;
        }

        return response()->json(['bookmarked' => $this->bookmarked]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bookmark-button');
    }
}
