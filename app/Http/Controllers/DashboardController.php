<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\PostGroup;
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
            ->get();
        } else {
            $posts = Post::with('user')->latest()->get();
        }
        
        return view('dashboard', [
            'posts' => $posts,
        ]);
    }
}
