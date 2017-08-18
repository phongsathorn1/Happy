<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@timeline')->name('home');
Route::get('/discover', 'DiscoverController@index')->name('discover');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/upload', 'UploadController@index')->name('upload');
Route::post('/upload/image', 'UploadController@post');
Route::post('/upload/post', 'UploadController@store');
Route::post('/follow/create', 'FollowController@create');
Route::post('/follow/unfollow', 'FollowController@delete');
Route::get('/posts/{post_id}', 'PostController@view');
Route::get('/user/{username}', 'ProfileController@view');
Route::get('/user/{username}/follower', 'ProfileController@follower');
Route::get('/user/{username}/following', 'ProfileController@following');
Route::get('/profile/edit', 'ProfileController@edit')->name('edit_profile');
Route::post('/profile/edit', 'ProfileController@save_edit');
Route::get('/profile/username', 'Auth\RegisterController@setUsername')->name('set_username');
Route::post('/profile/username', 'Auth\RegisterController@saveUsername');
Route::get('/posts/{post_id}/delete', 'PostController@delete');
Route::get('/posts/{post_id}/edit', 'PostController@edit');
Route::post('/posts/{post_id}/edit', 'PostController@save');

Route::post('/comment', 'CommentsController@create');
Route::post('/posts/{post_id}/like', 'PostController@like');
Route::post('/posts/{post_id}/unlike', 'PostController@unlike');

//Ajax request
Route::get('/api/search/{keyword}', 'SearchController@search');

//Social Login
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');