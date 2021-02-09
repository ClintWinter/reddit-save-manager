<?php

namespace App;

use App\Save;
use App\Type;
use App\Tag;
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

    public function handleToken()
    {
        if ($this->tokenExpired()) {
            $this->refreshToken();
        }
    }

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

    public function saves()
    {
        return $this->hasMany(Save::class)->with(['subreddit', 'type', 'tags']);
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

    public function getSubredditsWithCount($orderBy = 'subreddits.name')
    {
        return $this->saves()
                ->select(['subreddits.*', \DB::raw('count(1) as count')])
                ->join('subreddits', 'saves.subreddit_id', 'subreddits.id')
                ->groupBy('subreddit_id')
                ->orderBy($orderBy)
                ->get();
    }
}
