<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
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

        return response()->json(['message' => 'Comment created successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, $comment_id): JsonResponse
    {   
        $comment = Comment::findOrFail($comment_id);

        $comment->update($request->validated());
 
        return response()->json(['message' => 'Comment edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($comment_id): JsonResponse
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->post->decrement('comment_count');
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function getCommentsForPost($post_id): JsonResponse
    {
        $comments = Comment::where('post_id', $post_id)->with('user')->get();
        
        return response()->json($comments);
    }

    public function template(): string
    {
        // Render the Blade view and return as a response
        return view('comments.template')->render();
    }
}
