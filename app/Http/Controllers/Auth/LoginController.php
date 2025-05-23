<?php

namespace App\Http\Controllers\Auth;

use App\User; 
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Redirect;
use App\SystemSetting; 

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
     * 
     */
    protected $redirectTo;

    public function redirectTo() {

        if (session()->has('url.intended')) {
            return session()->pull('url.intended', '/home');
        }

        switch(Auth::user()->role){
            case 'registered':
                return '/register2';
                break;
                default:
                return '/choose-profile'; 
                break;

            }


        // $role = Auth::user()->role; 
        // switch ($role) {
        //     case 'registered':
        //     return '/register2';
        //     break;
        //     default:
        //     return '/home'; 
        //     break;
        // }
    }

    // protected function validateLogin(Request $request)
    // {
    //     $user = User::where($this->username(), '=', $request->input($this->username()))->first();
    //     if ($user && ! $user->active) {
    //         throw ValidationException::withMessages([$this->username() => __('The account is inactive')]);
    //     }
    //     $request->validate([
    //         $this->username() => 'required|string',
    //         'password' => 'required|string',
    //     ]);
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
        $request['email'] = str_replace(' ', '', $request['email']);
        $request['password'] = str_replace(' ', '', $request['password']);
        
        $data = $request->all();
        if(!empty($request['email']) && !empty($request['password'])){

                $user = User::where('email',$data['email'])->first('provider');
                $system_settings = SystemSetting::first();

                if(!empty($user) && $user->provider == 'facebook' || !empty($user) &&   $user->provider == 'google'){

                                return Redirect::to('/')->with(array(
                        'message' => 'Your account is connected with '.ucfirst($user->provider).'. Please sign in with '.ucfirst($user->provider).' given below.',
                    ));

                }
                if(!isset($data)){
                    $this->middleware('guest')->except('logout');
                    // return Redirect::to('/');
                }
            }
    }
}
