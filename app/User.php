<?php

namespace App;

use App\Save;
use App\Type;
use App\Subreddit;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'reddit_id', 'reddit_username', 'access_token', 'refresh_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'email', 'email_verified_at', 'password', 'remember_token', 'reddit_id', 'access_token', 'refresh_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function refreshToken() 
    {
        $httpClient = new Client([]);
        $response = $httpClient->post('https://www.reddit.com/api/v1/access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string'),
            ],
            'auth' => [config('services.reddit.client_id'), config('services.reddit.client_secret')],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refresh_token,
            ],
        ]);
    
        $credentialsResponseBody = json_decode($response->getBody(), true);
    
        $this->access_token = $credentialsResponseBody['access_token'];
        $this->save();
    }

    public function tokenExpired()
    {
        return time() > strtotime($this->updated_at) + 3600;
    }

    public function newSaves()
    {
        $httpClient = new Client([]);
        $response = $httpClient->get(
            'https://oauth.reddit.com/user/'.$this->name.'/saved',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->access_token,
                    'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string')
                ],
                'query' => [
                    'after' => null,
                    'before' => null,
                    'show' => 'all',
                    'count' => 10,
                    'username' => $this->username,
                    'limit' => 100
                ]
            ]
        );
        $body = json_decode($response->getBody(), true);
        $saves = collect($body['data']['children'])->pluck('data');

        $redditIdsArray = $saves->pluck('name')->toArray();

        $saveRecords = $this->saves()->whereIn('reddit_id', $redditIdsArray)->pluck('reddit_id');

        $newSaves = array_diff($redditIdsArray, $saveRecords->toArray());
        
        return $saves->filter(function($save) use ($newSaves) {
            return in_array($save['name'], $newSaves);
        });
    }

    public function newSave($save)
    {
        $prefix = explode('_', $save['name'])[0];
        $type = ( $prefix == 't1' ? 'comment' : ( $prefix == 't3' && empty( $save['media'] ) ? 'text' : 'link' ) );

        $newSave = new Save;

        $newSave->user_id = $this->id;
        $newSave->reddit_id = $save['name'];
        $newSave->type_id = Type::whereType($type)->first()->id;
        $newSave->subreddit_id = Subreddit::firstOrCreate(['name' => $save['subreddit']])->id;

        if ( $type == 'comment') {
            $newSave->link = $save['link_permalink'];
            $newSave->title = $save['link_title'];
            $newSave->body = $save['body_html'];
            
        } elseif ( $type == 'link' ) {
            
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = '';
            
        } else {
            
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = $save['selftext_html'];
            
        }

        $newSave->save();
    }

    public function saves() 
    {
        return $this->hasMany(Save::class)->with(['subreddit', 'type', 'tags']);
    }

    public function types() 
    {
        return $this->hasManyThrough(Save::class, 'type_id');
    }

    public function getFilters() 
    {        
        $saves = $this->saves()->with(['subreddit', 'tags', 'type'])->get();
        
        $subreddits = $saves->sortBy(function($save) {
            return strtolower($save['subreddit']['name']);
        })->pluck('subreddit.name')->unique();
        $tags = $saves->pluck('tags')->flatten()->sortBy('name')->pluck('name')->unique();
        $types = $saves->sortBy('type.type')->pluck('type.type')->unique();

        

        return [
            'subreddits' => $subreddits, 
            'tags' => $tags, 
            'types' => $types
        ];
    }
    
}
