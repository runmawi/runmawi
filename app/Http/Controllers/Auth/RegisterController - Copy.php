<?php

namespace App\Http\Controllers\Auth;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;


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
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => ['required', 'string'],
//            'username' => ['required', 'string'],
//            'email' => ['required', 'string', 'email', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'username' => $data['username'],
//            //'mobile' => $data['mobile'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);
//    }
    
    
    /**
 * Show the application registration form.
 *
 * @return \Illuminate\Http\Response
 */
        public function showRegistrationForm(Request $request)
        {
            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }

            return view('auth.register');
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
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'unique:users', 'alpha_dash', 'min:3', 'max:30'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param array $data
         *
         * @return \App\Models\User
         */
        protected function create(array $data)
        {
            $referrer = User::whereUsername(session()->pull('referrer'))->first();

            return User::create([
                'name'        => $data['name'],
                'username'    => $data['username'],
                'email'       => $data['email'],
                'referrer_id' => $referrer ? $referrer->id : null,
                'password'    => Hash::make($data['password']),
            ]);
        }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
//        if ($user->referrer !== null) {
//            Notification::send($user->referrer, new ReferrerBonus($user));
//        }

        return redirect($this->redirectPath());
        
    }
    
    
    
    
}
