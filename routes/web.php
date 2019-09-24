<?php

Auth::routes();

// UnAuth App Page
Route::get('/', function() {
    if (Auth::check()) {
        return redirect('/home');
    }

    return view('welcome');
});

// Auth App Page
Route::get('/home', 'HomeController@index')->name('home');

// Saves

// Tags
Route::middleware('auth')->group(function() {

    Route::get('/saves', 'SaveController@index');
    Route::post('/saves', 'SaveController@store');

    Route::prefix('/saves/{save}')->group(function() {
        Route::delete('/', 'SaveController@destroy');
        Route::post('/tags', 'SaveTagController@store');
        Route::delete('/tags/{tag}', 'SaveTagController@destroy');
    });

});

// Filters
Route::get('/filters', function() {
    return Auth::user()->getFilters();
})->middleware('auth');

// User
Route::get('/user', function() {
    return Auth::user();
})->middleware('auth');

// Reddit OAuth
Route::get('/reddit/redirect', 'Auth\LoginController@redirectToProvider')->name('reddit.redirect');
Route::get('/reddit/callback', 'Auth\LoginController@handleProviderCallback');
