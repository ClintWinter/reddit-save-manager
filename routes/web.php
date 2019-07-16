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

use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
})->middleware('auth');

Route::get('/refresh_token/{token}', function($token) {
    $httpClient = new Client([]);

    $response = $httpClient->post('https://www.reddit.com/api/v1/access_token', [
        'headers' => [
            'Accept' => 'application/json',
            'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string'),
        ],
        'auth' => [config('services.reddit.client_id'), config('services.reddit.client_secret')],
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
        ],
    ]);

    $credentialsResponseBody = json_decode($response->getBody(), true);

    $user = Auth::user();
    $user->access_token = $credentialsResponseBody['access_token'];
    $user->save();

    return $user->access_token;
})->middleware('auth');

/************************************/


/*
$this->getHttpClient()->get(
    'https://oauth.reddit.com/api/v1/me', [
    'headers' => [
        'Authorization' => 'Bearer '.$token,
        'User-Agent' => $this->getUserAgent(),
    ],
]);

return json_decode($response->getBody()->getContents(), true);

$response = $this->getHttpClient()->post($this->getTokenUrl(), [
    'headers' => [
        'Accept' => 'application/json',
        'User-Agent' => $this->getUserAgent(),
    ],
    'auth' => [$this->clientId, $this->clientSecret],
    'form_params' => $this->getTokenFields($code),
]);

$this->credentialsResponseBody = json_decode($response->getBody(), true);

return $this->credentialsResponseBody;
*/