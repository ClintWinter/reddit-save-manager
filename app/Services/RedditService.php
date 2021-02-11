<?php

namespace App\Services;

use App\Save;
use App\User;
use App\Subreddit;
use App\Support\TypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class RedditService {

    public function syncSaves($user, $syncAll = false)
    {
        $user->handleToken();

        $getOlderSaves = true;

        $savesCollection = new Collection(['not empty']);

        // if the last one exists in the DB, we have overlap and can stop syncing
        while ($syncAll ? ! $savesCollection->isEmpty() : $getOlderSaves) {
            $response = Http::timeout(10)->withHeaders([
                'Authorization' => "bearer {$user->access_token}",
                'User-Agent' => sprintf('%s:%s:%s', config('services.reddit.platform'), config('services.reddit.app_id'), config('services.reddit.version_string')),
            ])->get("https://oauth.reddit.com/user/{$user->name}/saved", [
                'after' => $reddit_id ?? null,
                'before' => null,
                'show' => 'all',
                'username' => $user->username,
                'limit' => 100,
            ]);

            $savesCollection = collect(json_decode($response->body(), true)['data']['children'])->pluck('data');

            if ($savesCollection->isEmpty()) {
                break;
            }

            $reddit_id = $savesCollection->last()['name'];

            $getOlderSaves = ! Save::where('reddit_id', $reddit_id)->exists();

            $saves = $this->mapSaves($savesCollection, $user);

            $user->saves()->upsert(
                $saves,
                ['user_id', 'reddit_id'],
                array_keys($saves[0])
            );
        }
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
                $result['reddit_url'] = 'https://reddit.com' . $save['permalink'];
                $result['thumbnail_url'] = null;
                $result['media_url'] = null;
                $result['title'] = $save['link_title'];
                $result['body'] = $save['body_html'];
            } elseif ($result['type_id'] === TypeEnum::LINK) {
                $result['reddit_url'] = 'https://reddit.com' . $save['permalink'];
                $result['thumbnail_url'] = $save['thumbnail'] ?? null;
                $result['media_url'] = $save['url_overriden_by_dest'] ?? $save['url'] ?? null;
                $result['title'] = $save['title'];
                $result['body'] = '';
            } else {
                $result['reddit_url'] = $save['url'];
                $result['thumbnail_url'] = null;
                $result['media_url'] = null;
                $result['title'] = $save['title'];
                $result['body'] = $save['selftext_html'];
            }

            unset($save['selftext_html'], $save['body_html'], $save['title'], $save['url'], $save['url_overriden_by_dest'], $save['thumbnail'], $save['permalink'], $save['link_title'], $save['media_metadata'], $save['selftext']);

            $result['metadata'] = json_encode($save);

            return $result;
        })->toArray();
    }
}
