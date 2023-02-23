<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user()->load('groups:id,title,slug');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show'); //get post
    Route::post('/post', [PostController::class, 'store'])->name('post.add'); //get post
    Route::patch('/post/{post}', [PostController::class, 'update'])->name('post.update'); //update post
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete'); //delete post


    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.add'); //get category
    Route::patch('/category/{category}', [CategoryController::class, 'update'])->name('category.update'); //update category
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.delete'); //delete category

    Route::get('/group/{group}', [GroupController::class, 'show'])->name('group.show');
    Route::post('/group', [GroupController::class, 'store'])->name('group.add'); //get group
    Route::patch('/group/{group}', [GroupController::class, 'update'])->name('group.update'); //update group
    Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('group.delete'); //delete group


    Route::post('/comment', [CommentController::class, 'store'])->name('comment.add'); //get comment
    Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update'); //update comment
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.delete'); //delete comment

    Route::post('/message', [MessageController::class, 'store'])->name('message.add'); //get message
    Route::patch('/message/{comment}', [MessageController::class, 'update'])->name('message.update'); //update message
    Route::delete('/message/{comment}', [MessageController::class, 'destroy'])->name('message.delete'); //delete message

});

Route::get('/posts', [PostController::class, 'index'])->name('post.all');

//category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('category.all');

Route::get('/groups', [GroupController::class, 'index'])->name('group.all');
