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

Route::get('/reddit/redirect', 'Auth\LoginController@redirectToProvider')->name('reddit.redirect');
Route::get('/reddit/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/user', function() {
    if (Auth::user()) {
        return Auth::user();
    }
});