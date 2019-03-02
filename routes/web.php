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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', 'UserController@login')->name('get.token');

Route::get('/callback', 'UserController@getToken');

Route::get('/dashboard', 'UserController@dashboard');

Route::post('/validateEmail', 'UserController@validateEmail');

Route::get('/logout', 'UserController@logout');