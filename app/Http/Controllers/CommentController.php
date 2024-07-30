<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'post_id' => 'required',
        ]);
 
        $comment = $request->user()->comments()->create($validated);
        $comment->post->increment('comment_count');
 
        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {           
        $postId = $comment->post->id;
        $commentId = $comment->id;
        $inputName = "message-{$postId}-{$commentId}";
        
        // Dynamically validate the input
        $validated = $request->validate([
            $inputName => 'required|string|max:255',
        ], [
            "{$inputName}.required" => 'The message field is required.',
            "{$inputName}.string" => 'The message must be a string.',
            "{$inputName}.max" => 'The message must not be greater than 255 characters.',
        ]);

        $comment->update(['message' => $validated[$inputName]]);
 
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->post->decrement('comment_count');
        $comment->delete();

        return redirect(route('dashboard'));
    }
}
