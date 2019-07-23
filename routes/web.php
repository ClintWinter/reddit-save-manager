<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;


Route::get('/reddit/redirect', 'Auth\LoginController@redirectToProvider')->name('reddit.redirect');
Route::get('/reddit/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/', function () {
    if (Auth::user()) return redirect('/home');
    
    return view('welcome');
});

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

    foreach ($saves as $save) 
    {

        $prefix = explode('_', $save['name'])[0];
        $type = ( $prefix == 't1' ? 'comment' : ( $prefix == 't3' && empty( $save['media'] ) ? 'link' : 'text' ) );


        $newSave = Auth::user()
            ->saves()
            ->with([
                'subreddit' => function($query) use ($save) { $query->whereName($save['subreddit'])->get(); },
                'type' => function($query) use ($type) { $query->whereType($type)->get(); }
            ])
            ->firstOrNew([
                'title' => isset( $save['title'] )  ? $save['title'] : $save['link_title'],
            ]);
        
        $dbType = App\Type::whereType($type)->first();
        $subreddit = App\Subreddit::firstOrCreate(['name' => $save['subreddit']]);

        $newSave->type()->associate($dbType);
        $newSave->subreddit()->associate($subreddit);

        if ( $type == 'comment') {
            $newSave->link = $save['link_permalink'];
            $newSave->title = $save['link_title'];
            $newSave->body = $save['body_html'];
            
        } elseif ( $type == 'link' ) {
            
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = $save['url'];
            
        } else {
            
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = $save['selftext_html'];
            
        }

        $newSave->save();
    }

    return Auth::user()->saves()->with(['subreddit', 'tags', 'type'])->get();
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

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