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

Route::get('blog/{slug}', ['as' =>'blog.single', 'uses' => 'blogController@getSingle']); //index page
Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);
Route::get('contact', 'PagesController@getContact');
Route::get('about', 'PagesController@getAbout');
Route::get('/', 'PagesController@getIndex');
Route::resource('posts', 'PostController');

Auth::routes();

Route::get('/home', 'HomeController@index');
