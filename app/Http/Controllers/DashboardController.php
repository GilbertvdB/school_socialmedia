<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Mixed_;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        $user = Auth::user();
        
        if($user->role == 'admin')
        {
            $posts = Post::with('user')->latest()->paginate(5);
        } else {
            $posts = $this->getUserGroupsPosts($user);
        }

        return view('dashboard', [
            'posts' => $posts,
        ]);
    }

    /**
     * Display and load more listing of the resource when the user scrolls down.
     */
    public function loadMorePosts(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if($user->role == 'admin')
        {
            $posts = Post::with('user')->latest()->paginate(5);
        } else {
            $posts = $this->getUserGroupsPosts($user);
        }
        
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
        $bookmarks = Bookmark::where('user_id', $user->id)->paginate(5);

        return view('posts.bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }

    /**
     * Retrieve all posts of the groups a user belongs to.
     */
    public function getUserGroupsPosts($user): Collection
    {   
        // Query to retrieve posts where the user belongs to the post groups
        $posts = Post::whereHas('postGroups', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })
        ->with('user') // Eager load the user relationship for each post
        ->latest()     // Order by latest created_at timestamp
        ->paginate(5);
        
        return $posts;
    }

    /**
     * Renders each post view into one html file.
     */
    public function renderPostsHtml($posts): String
    {
        $html = '';
        foreach ($posts as $post) {
            $html .= view('posts.post-box', compact('post'))->render();
        }

        return $html;
    }
}
