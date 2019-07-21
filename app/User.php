<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GuzzleHttp\Client;

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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function refreshToken() {
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

    public function saves() 
    {
        return $this->hasMany(Save::class);
    }

    public function types() 
    {
        return $this->hasManyThrough(Save::class, 'type_id');
    }

    public function subreddits() 
    {
        return $this->hasManyThrough(Subreddit::class, Save::class);
    }
}
