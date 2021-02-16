<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Setting;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $path = public_path().'/uploads/avatars/';
        $string = Str::random(60);
        
       
        $user = User::create([
            'name' => $data['name'],
            'role' => 'registered',
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'activation_code' => $string,
        ]);
            $settings = Setting::first();
            Mail::send('emails.verify', array('activation_code' => $string, 'website_name' => $settings->website_name), function($message) use ($data) {
                        $message->to($data['email'], $data['username'])->subject('Verify your email address');
                     });

            return $user;
    }


     public function Verify($activation_code){
        
        $user = User::where('activation_code', '=', $activation_code)->first();
        $fetch_user = User::where('activation_code', '=', $activation_code)->first();
                $mobile = $fetch_user->mobile;
                session()->put('register.email',$fetch_user->email);
                session()->put('email',$fetch_user->email);
                session()->put('register.username',$fetch_user->username);
           

        if($user){
            $user = User::where('activation_code', $activation_code)
                      ->update(['active' => 1]);

        return redirect('/register2')->with('message', 'You have successfully verified your account. Please login below.');
          } else {
            // print_r('expression');
            // exit;
             return redirect('/')->with('message', 'Invalid Activation.');
        }
       
    }
    
}
