<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShareController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    $posts = \App\Models\Post::where('parent_id', 0)->with('comments')->get();
    return view('home', ['posts' => $posts]);
})->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::post('/posts/{postId}/comment', [PostController::class, 'createComment']);
    Route::post('/comments/{commentId}/reply', [PostController::class, 'replyComment']);
    Route::post('/posts/{postId}/like', [LikeController::class, 'likePost']);
    Route::post('/posts/{postId}/share', [ShareController::class, 'sharePost']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
