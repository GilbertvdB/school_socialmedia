<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\PostGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        $user = Auth::user();
        
        if($user->role !== 'admin')
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
        } else {
            $posts = Post::with('user')->latest()->paginate(5);
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
    
    if ($user->role !== 'admin') {
        $posts = Post::whereHas('postGroups', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })
        ->with('user')
        ->latest()
        ->paginate(5);
    } else {
        $posts = Post::with('user')->latest()->paginate(5);
    }
    
    $html = '';
    foreach ($posts as $post) {
        $html .= view('posts.post-box', compact('post'))->render();
    }

    return response()->json([
        'html' => $html,
        'next_page_url' => $posts->nextPageUrl(),
    ]);
}

}
