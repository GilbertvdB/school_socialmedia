<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $id = Auth::user()->id;
        // dd(Post::find($id));
        return view('posts.index', [
            'posts' => Post::where('author_id', auth()->user()->id)->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $postGroups = PostGroup::all();
        return view('posts.create', compact('postGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'post_groups' => 'array',
            'post_groups.*' => 'exists:post_groups,id',
        ]);

        $post = $request->user()->posts()->create($validated);

        if ($request->has('post_groups')) {
            $post->postGroups()->attach($request->post_groups);
        }

        // Additional logic, e.g., redirect or return response
        return redirect(route('posts.index'))->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
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
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);
 
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'post_groups' => 'array',
            'post_groups.*' => 'exists:post_groups,id',
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        // Sync the post groups, attaching the selected tags
        if ($request->has('post_groups')) {
            $post->postGroups()->sync($request->post_groups);
        }
 
        return redirect(route('posts.edit', $post->id))->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
 
        $post->delete();
 
        return redirect(route('posts.index'))->with('success', 'Post deleted successfully.');
    }
}
