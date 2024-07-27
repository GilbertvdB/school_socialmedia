<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Notifications\NewPost;
use App\View\Components\LikeButton;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/posts', [DashboardController::class, 'loadMorePosts'])->name('dashboard.posts');
    Route::post('/posts/{post}/toggle-like', [LikeButton::class, 'toggleLike'])->name('posts.toggle-like');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/classrooms', ClassroomController::class);
    Route::resource('/postgroups', PostGroupController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/students', StudentController::class);
    
    // development routes
    Route::get('/notification', function () {
        $post = Post::find(17);
     
        return (new NewPost($post))
                    ->toMail($post->user);
    });
});

Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
