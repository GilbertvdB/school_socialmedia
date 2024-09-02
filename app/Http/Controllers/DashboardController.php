<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\View\View;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Services\PostCacheService;

class DashboardController extends Controller
{   
    private $postCacheService;

    public function __construct(PostCacheService $postCacheService)
    {
        $this->postCacheService = $postCacheService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        $user = Auth::user();
        $cacheKey = $this->postCacheService->generateCacheKeyForPosts($user);

        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function() {
            return $this->getPostsAccordingToRole();
        });
        
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
        $page = $request->query('page', 2);
        $cacheKey = $this->postCacheService->generateCacheKeyForPosts($user, $page);

        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function() {
            return $this->getPostsAccordingToRole();
        });
        
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
        $itemsPerPage = config('post-pagination.items'); //5 items per page

        return ($user->role === Role::Admin) 
                    ? Post::with('user')->latest()->paginate($itemsPerPage) //show all latest posts
                    : $this->getUserGroupsPosts($user);
    }

    /**
     * Retrieve all posts of the groups a user belongs to.
     */
    private function getUserGroupsPosts($user): LengthAwarePaginator
    {   
        $itemsPerPage = config('post-pagination.items'); //5 items per page

        // Query to retrieve posts where the user belongs to the post groups
        $posts = Post::whereHas('postGroups', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })
        ->with('user')
        ->latest()
        ->paginate($itemsPerPage);
        
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
