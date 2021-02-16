<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use DB;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Session;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }
    
     public function login(Request $request)
        {
         
         
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);
         
         
           $previous = $request->input('previous');

            $user = DB::table('users')->where('email', $request->input('email'))->first();
            $user_exist = DB::table('users')->where('email', $request->input('email'))->count();

            if (auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active'=> 1 ])) {
                $new_sessid   = Session::getId(); //get new session_id after user sign in
                if($user->session_id != '') {
                    $last_session = Session::getHandler()->read($user->session_id); 
                    if ($last_session) {
                        if (Session::getHandler()->destroy($user->session_id)) {
                        }
                    }
                }
               
                \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);
                $user = auth()->guard('web')->user();
                return redirect('/');
            }  else { 
               
                if ( $user_exist > 0 && $user->active == 0 ) { 
                    //\Session::put('login_error', 'Your email and password wrong or Not an active user!!');
                    Session::flash('message', "You are not an active user");
                    return Redirect::back();
                } else {
                    Session::flash('message', "Your email and password wrong");
                    return Redirect::back();
                }
               //return back();
               return Redirect::back()->withErrors(['login_error', 'Your email and password wrong or Not an active user!! ']);

        }
     }
    
     public function logout(Request $request)
        {
            \Session::flush();
            \Session::put('success','you are logout Successfully');
            return redirect()->to('/login');
        }

    
}
