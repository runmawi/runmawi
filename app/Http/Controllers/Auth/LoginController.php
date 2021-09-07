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
        switch(Auth::user()->role){
            case 'registered':
                return '/register2';
                break;
                default:
                return '/home'; 
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
