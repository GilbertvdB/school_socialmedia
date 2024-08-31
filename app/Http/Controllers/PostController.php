<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\PostGroup;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use App\Traits\UploadableFile;
use App\Services\PostCacheService;

class PostController extends Controller
{   
    use UploadableFile;

    protected $postCacheService;

    public function __construct(PostCacheService $postCacheService)
    {
        $this->postCacheService = $postCacheService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $author = Auth::user();
        return view('posts.index', [
            'posts' => Post::whereBelongsTo($author)->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {   
        $postGroups = PostGroup::all();
        return view('posts.create', compact('postGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): RedirectResponse
    { 
        $post = $request->user()->posts()->create($request->validated());
        $post->published_at = $post->created_at;
        $post->save();
        
        if ($request->has('post_groups')) 
        {
            $post->postGroups()->attach($request->post_groups);
        }
        
        // Handle file uploads
        $this->uploadImages($request, $post);
        $this->uploadDocuments($request, $post);

        // Invalidate caches for all groups associated with this post
        $this->postCacheService->invalidateCacheForPosts($post);
        
        return redirect(route('posts.index'))->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        Gate::authorize('view', $post);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);
 
        return view('posts.edit', [
            'post' => $post,
            'postGroups' => PostGroup::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostStoreRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);
 
        $validated = $request->validated();

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'published_at' => Carbon::now(),
        ]);

        // Sync the post groups, attaching the selected tags
        if ($request->has('post_groups')) 
        {
            $post->postGroups()->sync($request->post_groups);
        }
        
        // Handle file uploads
        $this->uploadImages($request, $post);
        $this->uploadDocuments($request, $post);

        // Invalidate caches for all groups associated with this post
        $this->postCacheService->invalidateCacheForPosts($post);
 
        return redirect(route('posts.edit', $post->id))->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
        
        $this->removeFile($post->images);
        $this->removeFile($post->documents);
        
        // Invalidate caches for all groups associated with this post
        $this->postCacheService->invalidateCacheForPosts($post);

        $post->delete();
 
        return redirect(route('posts.index'))->with('success', 'Post deleted successfully.');
    }
}
