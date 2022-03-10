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

// Route::middleware('auth:api')->get('/user', function (Request $request) { 
//     return $request->user(); 
// });

Route::apiResource('/posts', 'PostController');
Route::get('/post', 'PostController@allPosts');
Route::apiResource('/categories', 'CategoryController');
Route::apiResource('/comments', 'CommentController');
Route::get('/posts/category/{slug}', 'PostController@category');
Route::post('/users/register', 'UsersController@register');
Route::post('/users/login', 'UsersController@login');
Route::get('/all/categories', 'CategoryController@getAll');
Route::apiResource('/reply_comments', 'ReplyCommentController');
Route::post('/reply', 'ReplyCommentController@store');

Route::post('/changePassword', 'UsersController@changePassword');

Route::get('posts/author/{id?}', 'PostController@author');

Route::get('getUsers', 'UsersController@allUsers');
Route::get('UsersWithTrashed', 'UsersController@UsersWithTrashed');
Route::delete('user/{id}/{idAdmin}', 'UsersController@destroy');
Route::get('user/{id}', 'UsersController@user');
Route::post('editUser/{id}', 'UsersController@editUser');
Route::post('restore/user/{id}', 'UsersController@restore');


Route::get('category/{id}', 'CategoryController@getCategory');
Route::get('userInfo/{id}', 'UsersController@userInfo');


