<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Auth;
use App\User;

class RazorpayMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $users_details =Auth::User();

        if($users_details != null){
            $user_details =Auth::User();
        }else{
            $userEmailId = $request->session()->get('register.email');
            $user_details =User::where('email',$userEmailId)->first();        
        }
        if($user_details != null){
            return $next($request);
        }
        else{
            return redirect('login');
        }
    }
}
