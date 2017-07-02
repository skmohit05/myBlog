<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Authentication Routes
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

//password reset routes
// Password Reset Routes...
   Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
   Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
   Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.token');
   Route::post('password/reset', 'ResetPasswordController@reset');

// categories
   Route::resource('categories', 'CategoryController', ['except' => ['create']]);  //automatically display create,index,update,delete
//Tags
   Route::resource('tags', 'TagController', ['except' => ['create']]);
//Comments
   Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
   Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
   Route::put('comments/{id}/edit', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
   Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
   Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);

Route::get('blog/{slug}', ['uses' => 'BlogController@getSingle', 'as' =>'blog.single']); //index page
Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);
Route::get('contact', 'PagesController@getContact');
Route::post('contact', 'PagesController@postContact');
Route::get('about', 'PagesController@getAbout');
Route::get('/', 'PagesController@getIndex');
Route::resource('posts', 'PostController');

Auth::routes();

Route::get('/home', 'HomeController@index');
