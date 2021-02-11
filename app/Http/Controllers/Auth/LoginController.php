<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\RedditService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Socialite;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/saves';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('reddit')
            ->with([
                'duration' => 'permanent',
                'response_type' => 'code'
            ])
            ->scopes(['identity', 'edit', 'flair', 'history', 'modconfig', 'modflair', 'modlog', 'modposts', 'modwiki', 'mysubreddits', 'privatemessages', 'read', 'report', 'save', 'submit', 'subscribe', 'vote', 'wikiedit', 'wikiread'])
            ->redirect();
    }

    public function handleProviderCallback(RedditService $redditService)
    {
        try {
            $redditUser = Socialite::driver('reddit')->user();
        } catch(Exception $e) {
            return redirect('/');
        }

        $accessTokenResponseBody = $redditUser->accessTokenResponseBody;

        $user = User::where('reddit_id', $redditUser->getID())->first();

        if (! $user) {
            $user = new User;
            $user->name = $redditUser->nickname;
            $user->reddit_id = $redditUser->getId();
            $user->reddit_username = $redditUser->nickname;
            $user->email = $redditUser->getEmail();
            $user->access_token = $accessTokenResponseBody['access_token'];
            $user->refresh_token = $accessTokenResponseBody['refresh_token'];
            $user->save();
        } else {
            $user->access_token = $accessTokenResponseBody['access_token'];
            $user->refresh_token = $accessTokenResponseBody['refresh_token'];
            $user->save();
        }

        auth()->login($user, true);

        $redditService->syncSaves(auth()->user(), true);

        return redirect()->to('/saves');
    }
}
