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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/thread', 'ThreadController@index')->name('threads');
Route::get('/thread/create', 'ThreadController@create')->name('thread.create');
Route::get('/thread/{channel}', 'ThreadController@index');
Route::post('/thread', 'ThreadController@store')->name('thread.store');
Route::get('/thread/{channel}/{thread}', 'ThreadController@view')->name('thread');
Route::delete('/thread/{channel}/{thread}', 'ThreadController@destroy');

Route::get('/thread/{channel}/{thread}/reply', 'ReplyController@index');
Route::post('/thread/{channel}/{thread}/reply', 'ReplyController@create');
Route::delete('/reply/{reply}', 'ReplyController@destroy');
Route::patch('/reply/{reply}', 'ReplyController@update');

Route::get('/profiles/{user}', 'ProfileController@show');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

Route::delete('/reply/{reply}/favorite', 'FavoriteController@destroy');
Route::post('/reply/{reply}/favorite', 'FavoriteController@store');

Route::post('/thread/{channel}/{thread}/subscription', 'SubscriptionController@store');
Route::delete('/thread/{channel}/{thread}/subscription', 'SubscriptionController@destroy');

Route::get('/auth/{provider}', 'Auth\LoginController@loginSocial')->name('auth.social');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
