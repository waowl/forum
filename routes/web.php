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
Route::get('/thread/{channel}','ThreadController@index');
Route::get('/thread/create','ThreadController@create')->name('thread.create');
Route::post('/thread','ThreadController@store')->name('thread.store');
Route::get('/thread/{channel}/{thread}','ThreadController@view')->name('thread');
Route::post('/thread/{channel}/{thread}/reply','ReplyController@create');
