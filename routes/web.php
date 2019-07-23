<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;


Route::get('/reddit/redirect', 'Auth\LoginController@redirectToProvider')->name('reddit.redirect');
Route::get('/reddit/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/', function () {
    if (Auth::check()) return redirect('/home');
    
    return view('welcome');
});

Route::get('/saves', 'SaveController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', function() {
    if (Auth::check()) {
        return Auth::user();
    }
})->middleware('auth');

Route::get('/refresh_token/{token}', function($token) {
    $httpClient = new Client([]);

    $response = $httpClient->post('https://www.reddit.com/api/v1/access_token', [
        'headers' => [
            'Accept' => 'application/json',
            'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string'),
        ],
        'auth' => [
            config('services.reddit.client_id'), 
            config('services.reddit.client_secret')
        ],
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token
        ],
    ]);

    $credentialsResponseBody = json_decode($response->getBody(), true);

    $user = Auth::user();
    $user->access_token = $credentialsResponseBody['access_token'];
    $user->save();

    return $user->access_token;
})->middleware('auth');