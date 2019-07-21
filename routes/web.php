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


Route::get('/saves', function() {

    if ( time() > strtotime(Auth::user()->updated_at) + 3600 ) {
        Auth::user()->refreshToken();
    }

    $httpClient = new Client([]);
    $response = $httpClient->get(
        'https://oauth.reddit.com/user/'.Auth::user()->name.'/saved',
        [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->access_token,
                'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string')
            ],
            'query' => [
                'after' => null,
                'before' => null,
                'show' => 'all',
                'count' => 10,
                'username' => Auth::user()->username,
                'limit' => 100
            ]
        ]
    );

    $body = json_decode($response->getBody(), true);
    $saves = collect($body['data']['children'])->pluck('data');

    dd($saves);

    foreach ($saves as $save) 
    {
        // TODO: if it exists, continue the loop; otherwise, create it
        // How to we create it with an association to user?
        // also with findOrNew: we need a way to split the logic.
        // $newSave = Auth::user()->saves()->findOrNew([]);
        $newSave = new App\Save;
        
        $prefix = explode('_', $save['name'])[0];
        $subreddit = App\Subreddit::firstOrCreate(['name' => $save['subreddit']]);

        if ( $prefix == 't1') { // comment

            $newSave->type()->attach(App\Type::whereType('comment')->firstOrFail());
            $newSave->subreddit()->attach($subreddit);
            $newSave->link = $save['link_permalink'];
            $newSave->title = $save['link_title'];
            $newSave->body = $save['body_html'];
            
        } elseif ( $prefix == 't3' && ! empty( $save['media'] ) ) { // link
            
            $newSave->type()->attach(App\Type::whereType('link')->firstOrFail());
            $newSave->subreddit()->attach($subreddit);
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = '';
            
        } else { // text
            
            $newSave->type()->attach(App\Type::whereType('text')->firstOrFail());
            $newSave->subreddit()->attach($subreddit);
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = $save['selftext_html'];
            
        }

    }

    return $saves;
    
})->middleware('auth');

// axios.get(
// `https://oauth.reddit.com/user/${this.username}/saved`,
// { 
//     headers: { Authorization: this.authString },
//     params: {
//         after: null,
//         before: null,
//         show: 'all',
//         count: 10,
//         username: this.username,
//         limit: 11
//     }
// }
// )


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