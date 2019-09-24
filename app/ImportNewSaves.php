<?php

namespace App;

use App\Save;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class ImportNewSaves {

    private $user;

    private $client;
    
    public function __construct(Client $client)
    {
        $this->user = Auth::user();

        $this->client = $client;
    }

    public function handle()
    {
        $this
            ->get()
            ->each(function($save) {
                $this->import($save);
            });
    }

    private function get()
    {
        $saves = collect([]);
        $after = null;
        for ($i = 1; $i <= 10; $i++) {

            if ( $saves->count() ) {
                $after = $saves->last()['data']['name'];
            }

            $response = $this->client->get(
                'https://oauth.reddit.com/user/'.$this->user->name.'/saved',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->user->access_token,
                        'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string')
                    ],
                    'query' => [
                        'after' => $after,
                        'before' => null,
                        'show' => 'all',
                        'username' => $this->user->username,
                        'limit' => 100
                    ]
                ]
            );

            $body = json_decode($response->getBody(), true);
            $saves = $saves->concat(collect($body['data']['children']));

            if (! count($body['data']['children']))
                break;
        }

        // get all reddit saves
        $saves = $saves->pluck('data');

        // get reddit save IDs
        $redditIdsArray = $saves->pluck('name')->toArray();

        // get IDs of DB saves
        $saveRecords = $this->user->saves()->whereIn('reddit_id', $redditIdsArray)->pluck('reddit_id');

        // sort out the reddit IDs already in DB
        $newSaves = array_diff($redditIdsArray, $saveRecords->toArray());
        
        // filter the reddit saves by chicking if they are in the unsaved IDs
        return $saves->filter(function($save) use ($newSaves) {
            return in_array($save['name'], $newSaves);
        })->reverse();
    }

    private function import($save)
    {
        $prefix = explode('_', $save['name'])[0];
        $type = ( $prefix == 't1' ? 'comment' : ( $prefix == 't3' && strpos( $save['url'], 'https://www.reddit.com' ) !== false ? 'text' : 'link' ) );

        $newSave = new Save;

        $newSave->user_id = $this->user->id;
        $newSave->reddit_id = $save['name'];
        $newSave->type_id = Type::whereType($type)->first()->id;
        $newSave->subreddit_id = Subreddit::firstOrCreate(['name' => $save['subreddit']])->id;

        if ( $type == 'comment') {
            $newSave->link = 'https://reddit.com' . $save['permalink'];
            $newSave->title = $save['link_title'];
            $newSave->body = $save['body_html'];
            
        } elseif ( $type == 'link' ) {
            
            $newSave->link = 'https://reddit.com' . $save['permalink'];
            $newSave->title = $save['title'];
            $newSave->body = '';
            
        } else {
            
            $newSave->link = $save['url'];
            $newSave->title = $save['title'];
            $newSave->body = $save['selftext_html'];
            
        }

        $newSave->save();
    }
}