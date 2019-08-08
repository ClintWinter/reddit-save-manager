<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/home';

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
            ->scopes(['identity', 'edit', 'flair', 'history', 'modconfig', 'modflair', 'modlog', 'modposts', 'modwiki', 'mysubreddits', 'privatemessages', 'read', 'report', 'save', 'submit', 'subscribe', 'vote', 'wikiedit', 'wikiread'])
            ->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('reddit')->user();
        } catch(Exception $e) {
            return redirect('/login');
        }

        $accessTokenResponseBody = $user->accessTokenResponseBody;

        $ourUser = User::where('email', $user->getEmail())->first();

        if ( !$ourUser ) {
            $ourUser = new User;
            $ourUser->name = $user->nickname;
            $ourUser->reddit_id = $user->getId();
            $ourUser->reddit_username = $user->nickname;
            $ourUser->email = $user->getEmail();
            $ourUser->access_token = $accessTokenResponseBody['access_token'];
            $ourUser->refresh_token = $accessTokenResponseBody['refresh_token'];
            $ourUser->save();
        } else {
            $ourUser->access_token = $accessTokenResponseBody['access_token'];
            $ourUser->refresh_token = $accessTokenResponseBody['refresh_token'];
            $ourUser->save();
        }

        auth()->login($ourUser, true);

        return redirect()->to('/home');
    }
}
