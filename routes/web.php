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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/show-post/{post}', 'PostController@show')->name('show-post');
//Route::get('/show-all-active-posts', 'PostController@showAllActivePosts')->name('show-all-active-posts');
Route::post('/search', 'PostController@search')->name('search');

Route::middleware('checkAuth')->group(function(){
    Route::get('/show-profile/{user}', 'UserController@showProfile')->name('show-profile');
    Route::get('/edit-profile/{user}', 'UserController@edit')->name('edit-profile');
    Route::post('/update-profile/{user}', 'UserController@update')->name('update-profile');
    Route::get('/show-user-posts/{user}', 'PostController@showUserPosts')->name('show-user-posts');
    Route::get('/create-post', 'PostController@create')->name('create-post');
    Route::post('/store-post', 'PostController@store')->name('store-post');
    Route::get('/edit-post/{post}', 'PostController@edit')->name('edit-post');
    Route::post('/update-post/{post}', 'PostController@update')->name('update-post');
    Route::post('/delete-post/{post}', 'PostController@delete')->name('delete-post');
    Route::get('/inactive-post/{post}', 'PostController@setInactivePost')->name('inactive-post');
    Route::get('/success-post/{post}', 'PostController@setSuccessPost')->name('success-post');
    Route::get('/active-post/{post}', 'PostController@setActivePost')->name('active-post');
    Route::get('/posts-dashboard', 'AdminController@showPostsDashboard')->name('posts-dashboard');
    Route::get('/users-dashboard', 'AdminController@showUsersDashboard')->name('users-dashboard');
    Route::get('/tags-dashboard', 'AdminController@showTagsDashboard')->name('tags-dashboard');
    Route::get('/create-tag', 'TagController@create')->name('create-tag');
    Route::get('/edit-tag/{tag}', 'TagController@edit')->name('edit-tag');
    Route::post('/store-tag', 'TagController@store')->name('store-tag');
    Route::post('/update-tag/{tag}', 'TagController@update')->name('update-tag');
    Route::get('/delete-tag/{tag}', 'TagController@delete')->name('delete-tag');
    Route::get('/set-admin/{user}', 'AdminController@setAdminRole')->name('set-admin-role');
    Route::get('/set-user/{user}', 'AdminController@setUserRole')->name('set-user-role');
});
