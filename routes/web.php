<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Notifications\NewPost;
use App\View\Components\BookmarkButton;
use App\View\Components\LikeButton;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/loadMorePosts', [DashboardController::class, 'loadMorePosts'])->name('dashboard.loadMorePosts');
    Route::get('/bookmarks', [DashboardController::class, 'bookmarks'])->name('dashboard.bookmarks');
    
    //components routes
    Route::post('/posts/{post}/toggle-like', [LikeButton::class, 'toggleLike'])->name('posts.toggle-like');
    Route::post('/posts/{post}/toggle-bookmark', [BookmarkButton::class, 'toggleBookmark'])->name('posts.toggle-bookmark');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user:uuid}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/classrooms', ClassroomController::class);
    Route::resource('/postgroups', PostGroupController::class);
    Route::resource('/users', UserController::class);
    
    Route::resource('/students', StudentController::class)->except(['show']);
    Route::get('/students/{student:uuid}', [StudentController::class, 'show'])->name('students.show');
    
    Route::get('/posts/{post_id}/comments', [CommentController::class, 'getCommentsForPost']);
    Route::get('/comments/template', [CommentController::class, 'template']);
    Route::resource('/comments', CommentController::class);

    Route::delete('/posts/edit/document/{id}', [FileController::class, 'destroyDocument'])->name('document.destroy');
    Route::delete('/posts/edit/image/{id}', [FileController::class, 'destroyImage'])->name('image.destroy');
    
    Route::resource('posts', PostController::class)->middleware(['verified']);
    
    // development & testing routes
    Route::get('/notification', function () {
        $post = Post::find(41);
     
        return (new NewPost($post))
                    ->toMail($post->user);
    });
});


require __DIR__.'/auth.php';
