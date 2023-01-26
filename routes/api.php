<?php

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

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyCommentController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/posts', PostController::class);
Route::get('/post', [PostController::class, 'allPosts']);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/comments', CommentController::class);

Route::get('/posts/category/{slug}', [PostController::class, 'category']);

Route::post('/users/register', [UsersController::class, 'register']);
Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/all/categories', [CategoryController::class, 'getAll']);
Route::apiResource('/reply_comments', ReplyCommentController::class);
Route::post('/reply', [ReplyCommentController::class, 'store']);

Route::post('/changePassword', [UsersController::class, 'changePassword']);

Route::get('posts/author/{id?}', [PostController::class, 'author']);

Route::get('getUsers', [UsersController::class, 'allUsers']);
Route::get('UsersWithTrashed', [UsersController::class, 'UsersWithTrashed']);
Route::delete('user/{id?}/{idAdmin}', [UsersController::class, 'destroy']);
Route::get('user/{id}', [UsersController::class, 'user']);
Route::post('editUser/{id}', [UsersController::class, 'editUser']);
Route::post('restore/user/{id}', [UsersController::class, 'restore']);

Route::get('category/{id}', [CategoryController::class, 'getCategory']);
Route::get('userInfo/{id}', [UsersController::class, 'userInfo']);
