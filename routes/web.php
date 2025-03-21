<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/email', function (){
    return new \App\Mail\UserWelcome();
});

Route::post('/comment/{post}', [App\Http\Controllers\CommentsController::class, 'store']);
Route::post('/likeComment/{comment}', [App\Http\Controllers\CommentLikesController::class, 'store']);
Route::post('/like/{post}', [App\Http\Controllers\LikesController::class, 'store']);
Route::post('/follow/{user}', [App\Http\Controllers\FollowsController::class, 'store']);

Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
Route::get('/p/create', [App\Http\Controllers\PostsController::class, 'create']);
Route::post('/p', [App\Http\Controllers\PostsController::class, 'store']);
Route::get('/p/{post}/likes', [\App\Http\Controllers\PostsController::class, 'getLikes']);
Route::get('/{commentId}/likes', [\App\Http\Controllers\CommentLikesController::class, 'getLikes']);
Route::post('/p/{post}/update', [App\Http\Controllers\PostsController::class, 'update']);
Route::delete('p/{post}/delete', [App\Http\Controllers\PostsController::class, 'destroy']);
Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);
Route::get('/search', [App\Http\Controllers\SearchController::class, 'searchProfiles']);

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}/', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
