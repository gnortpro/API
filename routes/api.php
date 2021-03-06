<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('getProduct', 'PostController@getProduct');
    

    // mail
    Route::post('post-emails', 'MailController@create');
 });
// For wordpress
Route::post('createPost', 'PostController@create');
Route::post('updatePost', 'PostController@update');
Route::post('deletePost', 'PostController@delete');
Route::post('createCategory', 'CategoryController@create');
Route::post('deleteCategory', 'CategoryController@delete');
//For Nuxt
Route::get('readPost', 'PostController@read');

Route::post('testing', 'TestController@index');
