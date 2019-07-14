<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
            ->with([
                'redirect_uri' => 'http://localhost:8000/reddit/callback',
                'duration' => 'permanent',
                'response_type' => 'code'
            ])
            ->scopes(['identity', 'edit', 'mysubreddits', 'read', 'save'])
            ->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('reddit')->user();
        } catch(Exception $e) {
            return redirect('/login');
        }

        $ourUser = User::where('email', $user->email)->first();

        if ( $ourUser ) {
            auth()->login($ourUser, true);
        } else {
            $ourUser = new User;
            $ourUser->name = $user->getName();
            $ourUser->email = $user->getEmail();
            $ourUser->reddit_id = $user->getId();
            $ourUser->refresh_token = $user->refreshToken;
            $ourUser->save();
        }

        auth()->login($ourUser, true);

        return redirect()->to('/home');
    }
}
