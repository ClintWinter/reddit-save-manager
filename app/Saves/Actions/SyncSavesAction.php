<?php

namespace App\Saves\Actions;

use App\User;
use App\Subreddit;
use App\Support\TypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SyncSavesAction
{
    public function __invoke(User $user)
    {
        $user->handleToken();

        $response = Http::withHeaders([
            'Authorization' => "bearer {$user->access_token}",
            'User-Agent' => sprintf('%s:%s:%s', config('services.reddit.platform'), config('services.reddit.app_id'), config('services.reddit.version_string')),
        ])->get(
            "https://oauth.reddit.com/user/{$user->name}/saved",
            ['after' => null, 'before' => null, 'show' => 'all', 'username' => $user->username, 'limit' => 'none']
        );

        $saves = collect(json_decode($response->body(), true)['data']['children'])->pluck('data');
        $saveData = $this->mapSaves($saves, $user);

        $user->saves()->upsert($saveData->toArray(), ['reddit_id'], []);
    }

    private function mapSaves(Collection $saves, User $user)
    {
        return $saves->map(function ($save) use ($user) {
            $result = [];

            $prefix = explode('_', $save['name'])[0];
            $result['type_id'] = $prefix === 't1'
                ? TypeEnum::COMMENT
                : ($prefix === 't3' && strpos($save['url'], 'https://www.reddit.com') !== false
                    ? TypeEnum::TEXT
                    : TypeEnum::LINK);

            $result['user_id'] = $user->id;
            $result['reddit_id'] = $save['name'];
            $result['subreddit_id'] = Subreddit::firstOrCreate(['name' => $save['subreddit']])->id;
            $result['created_at'] = new Carbon($save['created']);

            if ($result['type_id'] === TypeEnum::COMMENT) {
                $result['link'] = 'https://reddit.com' . $save['permalink'];
                $result['title'] = $save['link_title'];
                $result['body'] = $save['body_html'];
            } elseif ($result['type_id'] === TypeEnum::LINK) {
                $result['link'] = 'https://reddit.com' . $save['permalink'];
                $result['title'] = $save['title'];
                $result['body'] = '';
            } else {
                $result['link'] = $save['url'];
                $result['title'] = $save['title'];
                $result['body'] = $save['selftext_html'];
            }

            return $result;
        });
    }
}
