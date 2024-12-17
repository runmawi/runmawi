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
        $user_details = Auth::user();
    
        if (is_null($user_details)) {
            $userEmailId = $request->session()->get('register.email');
    
            if ($userEmailId) {
                $user_details = User::where('email', $userEmailId)->first();
            }
        }
    
        if( !is_null($user_details) ){

            if( $user_details->role == "admin" ){
                return redirect('home');
            }

            return $next($request);
        }
        else{
            return redirect('login');
        }
    }
}