<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\View\View;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\Types\Mixed_;

class DashboardController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        $posts = $this->getPostsAccordingToRole();
        
        return view('dashboard', [
            'posts' => $posts,
        ]);
    }

    /**
     * Display and load more listing of the resource when the user scrolls down.
     */
    public function loadMorePosts(): JsonResponse
    {   
        $posts = $this->getPostsAccordingToRole();
        
        $html = $this->renderPostsHtml($posts);

        return response()->json([
            'html' => $html,
            'next_page_url' => $posts->nextPageUrl(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function bookmarks(): View
    {   
        $user = Auth::user();
        $bookmarks = Bookmark::whereBelongsTo($user)->paginate(5);

        return view('posts.bookmarks', compact('bookmarks'));
    }

    /**
     * Retrieve posts for the users proper role.
     */
    private function getPostsAccordingToRole(): Mixed
    {   
        $user = Auth::user();

        return ($user->role === Role::Admin) 
                    ? Post::with('user')->latest()->paginate(5) //show all latest posts
                    : $this->getUserGroupsPosts($user);
    }

    /**
     * Retrieve all posts of the groups a user belongs to.
     */
    private function getUserGroupsPosts($user): Collection
    {   
        // Query to retrieve posts where the user belongs to the post groups
        $posts = Post::whereHas('postGroups', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->whereBelongsTo($user);
            });
        })
        ->with('user')
        ->latest()
        ->paginate(5);
        
        return $posts;
    }

    /**
     * Renders each post view into one html file.
     */
    private function renderPostsHtml($posts): String
    {
        $html = '';
        foreach ($posts as $post) {
            $html .= view('posts.post-box', compact('post'))->render();
        }

        return $html;
    }
}
