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
Route::get('/thread','ThreadController@index')->name('threads');
Route::get('/thread/create','ThreadController@create')->name('thread.create');
Route::get('/thread/{channel}','ThreadController@index');
Route::post('/thread','ThreadController@store')->name('thread.store');
Route::get('/thread/{channel}/{thread}','ThreadController@view')->name('thread');
Route::delete('/thread/{channel}/{thread}','ThreadController@destroy');
Route::post('/thread/{channel}/{thread}/reply','ReplyController@create');
Route::post('/reply/{reply}/favorite','FavoriteController@store');
Route::get('/profiles/{user}', 'ProfileController@show');
Route::delete('/reply/{reply}', 'ReplyController@destroy');
Route::patch('/reply/{reply}', 'ReplyController@update');
