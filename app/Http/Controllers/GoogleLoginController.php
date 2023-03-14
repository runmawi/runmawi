<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Session;
use Hash;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request ,$provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect()->intended('/home');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($user)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'facebook_id' => $facebookUser->id,
        ]);
    }
}