<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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
        $postId = $request->post_id;
        $inputName = "title-{$postId}";

        $validated = $request->validate([
            $inputName => 'required|string|max:255',
            'post_id' => 'required',
        ]);
        
        $validated['message'] = $validated[$inputName];
        unset($validated[$inputName]);

        $comment = $request->user()->comments()->create($validated);
        $comment->post->increment('comment_count');
 
        // return redirect()->back();
        return response()->json(['message' => 'Comment created successfully']);
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
    public function update(Request $request, $comment_id)
    {   
        $comment = Comment::findOrFail($comment_id);
        // $postId = $comment->post->id;
        // $commentId = $comment->id;
        // $inputCommentName = "message-{$postId}-{$commentId}";

        // // Dynamically validate the input
        // $validated = $request->validate([
        //     $inputCommentName => 'required|string|max:255',
        // ]);

        // $comment->update(['message' => $validated[$inputCommentName]]);
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $comment->update($validated);
        $comment->save();
 
        return response()->json(['message' => 'Comment edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($comment_id)
    {
        // $comment->post->decrement('comment_count');
        // $comment->delete();
        // return redirect(route('dashboard'));

        $comment = Comment::findOrFail($comment_id);
        $comment->post->decrement('comment_count');
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function getCommentsForPost($post_id)
    {
        $comments = Comment::where('post_id', $post_id)->with('user')->get();
        
        return response()->json($comments);
    }

    public function template()
    {
        // Render the Blade view and return as a response
        return view('comments.template')->render();
    }
}
